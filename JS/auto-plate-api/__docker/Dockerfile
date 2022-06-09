FROM node:17.9-alpine3.15 as base
RUN apk update && apk upgrade && apk add --no-cache

WORKDIR /srv

COPY package*.json ./

RUN npm install

COPY . .

CMD npm run start