FROM php:8.1
WORKDIR /app
COPY . .
ENTRYPOINT [  ]
CMD [ "bash", "-c", "cd src && php -S 0.0.0.0:8080 ../index.php" ]