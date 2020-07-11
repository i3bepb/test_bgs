FROM nginx:1.19-alpine

ARG MY_USER
ARG MY_USER_ID

RUN addgroup -g ${MY_USER_ID} -S ${MY_USER} && adduser -S -u ${MY_USER_ID} ${MY_USER} -G ${MY_USER}

WORKDIR /usr/share/nginx/html