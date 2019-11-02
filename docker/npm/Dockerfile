FROM node:lts-alpine

# Set working directory
WORKDIR /var/www

RUN npm install --global cross-env

CMD npm install && npm run watch-poll
