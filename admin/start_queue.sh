#!/bin/sh

# Start the queue when rabbitmq container
until nc -z rabbitmq 5672; do
  echo "Waiting for RabbitMQ..."
  sleep 1
done

# Start the queue
php artisan queue:work --queue=admin_queue
