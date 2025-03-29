FROM nginx:latest
RUN echo "Starting nginx dockerfile"

# Create necessary directories
RUN mkdir -p /var/www/certbot /etc/nginx/conf.d

# Copy Nginx configuration files from your project to the container
COPY nginx/nginx-dev.conf /etc/nginx/conf.d/nginx-dev.conf
COPY nginx/nginx-test.conf /etc/nginx/conf.d/nginx-test.conf
COPY nginx/nginx-prod.conf /etc/nginx/conf.d/nginx-prod.conf
