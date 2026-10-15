# =========================================================================
# PHASE 1: SYSTEM & WEB SERVER ENVIRONMENT SETUP
# =========================================================================

# Step 1: Download the base operating system image from Docker Hub.
# This gives us a pre-configured Linux environment with PHP 8.2 and Apache Web Server ready to go.
FROM php:8.2-apache

# Step 2: Set an internal environment variable telling our app to use port 7860.
# Hugging Face Spaces strictly requires containers to listen on port 7860.
ENV PORT=7860

# Step 3: Tell Docker to open up port 7860 so the container can accept incoming web traffic.
EXPOSE 7860

# =========================================================================
# SYSTEM PACKAGES & GD IMAGE GRAPHICS CONFIGURATION
# =========================================================================
# Step 4: Install essential raw Linux operating system packages.
# - apt-get update: Refreshes the internal app catalog so Linux knows where to find new software.
# - unzip & git: Required by Composer to download and unpack PHP packages from the internet.
# - libfreetype6-dev, libjpeg62-turbo-dev, libpng-dev: Low-level graphic drivers needed to render text and Jpeg, PNG images with alpha channels (transparency).
# - --no-install-recommends: Keeps the container lightweight by skipping non-essential extra tools.
# - rm -rf ...: Deletes temporary installation files to shrink the final image file size.
RUN apt-get update && apt-get install -y --no-install-recommends \
    unzip \
    git \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && rm -rf /var/lib/apt/lists/*

# Step 5: Configure and compile the PHP GD graphics driver extension natively from source code.
# - docker-php-ext-configure gd: Directs the setup assistant to link our graphics engine to the font 
#   engine (--with-freetype) and the JPEG compressor (--with-jpeg) installed in Step 4.
# - docker-php-ext-install gd: Triggers the actual compilation into a functional PHP extension module and 
#   activates it automatically so we don't have to manually touch a php.ini configuration file.
# - -j$(nproc): An optimization trick that tells the compiler to use all available processor cores of 
#   your laptop or the cloud server at the same time, making the graphics driver build significantly faster.
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Step 5.5: Create the operational php.ini file from the template and enable output buffering.
# This mimics Laragon's default setup, preventing small string notices from crashing TCPDF streams!
RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini \
    && sed -i 's/output_buffering = Off/output_buffering = 4096/' /usr/local/etc/php/php.ini

# Step 6: Download the official Composer package manager execution binary.
# Instead of downloading it manually, this copies it directly from the official modern Composer image.
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Step 7: Modify the Apache web server configuration on the fly.
# By default, Apache listens on port 80. This uses the 'sed' stream editor tool to rewrite Apache's 
# internal files, forcing it to listen on port 7860 so it doesn't crash on Hugging Face Spaces.
RUN sed -i 's/Listen 80/Listen 7860/' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost \*:7860>/' /etc/apache2/sites-available/000-default.conf

# Step 8: Set the default system working folder inside the isolated Linux container environment.
# Any commands run after this line will automatically execute from inside '/var/www/html/'.
WORKDIR /var/www/html/


# =========================================================================
# PHASE 2: INCREMENTAL BUILDING (COMPOSER DEPENDENCY CACHE SHIELD)
# =========================================================================

# Step 9: Copy ONLY the composer configuration lists from your laptop into the container root.
# Because you edit your PHP code often but change your package list rarely, separating this step 
# allows Docker to flag this layer as [CACHED] and skip downloading packages on future code pushes!
COPY composer.json composer.lock* /var/www/html

# Step 10: Run the actual library package installer inside a secure memory vault.
# - --mount=type=cache...: Creates a persistent cache vault. If you add a new library later, Docker 
#   checks this directory and ONLY downloads the new addition, completely skipping re-downloading TCPDF or FPDI.
# - if [ -f ... ]: A protective shield checking if composer.json exists before attempting to install, 
#   preventing the build engine from crashing on standard text-only PHP projects.
# - --no-autoloader --no-scripts: Downloads the library code files but delays path mapping until your custom files arrive.
RUN --mount=type=cache,target=/root/.composer/cache \
    if [ -f "composer.json" ]; then composer install --no-dev --no-autoloader --no-scripts; fi


# =========================================================================
# PHASE 3: APPLICATION CODE LAYER & CLEANUP (Copies directly into the html folder)
# =========================================================================

# Step 11: Copy the rest of your custom PHP source code (services/, index.php, etc.) into the container.
# This layer breaks cache when you edit your code files, but because it sits below the dependency layer, 
# Docker skips everything above it and finishes subsequent builds in roughly 2 seconds!
COPY . /var/www/html/

# FONT INJECTION CRITICAL STEP:
# Step 12: Inject your local custom font assets directly into Composer's core installation directory.
# This copies your lowercase 'mont-heavydemo.php/.z' files straight into the live TCPDF package 
# folders inside the container so the backend engine can find and render your text vectors successfully.
RUN if [ -d "custom_fonts" ]; then cp custom_fonts/* /var/www/html/vendor/tecnickcom/tcpdf/fonts/; fi

# Step 13: Compile the final autoloader class files.
# Now that your custom scripts and custom fonts are safe inside the container, this creates the internal 
# PHP map so that your include scripts can read '/vendor/autoload.php' and hook up classes instantly.
RUN if [ -f "composer.json" ]; then composer dump-autoload --optimize; fi

# Step 14: Re-configure runtime execution permissions for the application files.
# Files copied into Docker are owned by the root administrator by default. Apache runs under a restricted 
# system profile named 'www-data'. This hands ownership to Apache so it can securely stream your files.
RUN chown -R www-data:www-data /var/www/html