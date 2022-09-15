FROM nginx:latest
ARG GATEWAY_SERVER_NAME
ARG POWERWALL_IP
ARG COOKIEBASEURL
ARG EMAIL
ARG USERNAME
ARG PASSWD
ARG URL
COPY ./default.conf /etc/nginx/conf.d/default.conf
RUN sed -i "s/gateway_server_name/${GATEWAY_SERVER_NAME}/g" /etc/nginx/conf.d/default.conf
RUN sed -i "s/powerwall_ip/${POWERWALL_IP}/g" /etc/nginx/conf.d/default.conf
RUN sed -i "s/gateway_username_tmp/${USERNAME}/g" /etc/nginx/conf.d/default.conf
RUN sed -i "s/gateway_email_tmp/${EMAIL}/g" /etc/nginx/conf.d/default.conf
RUN sed -i "s/gateway_passwd_tmp/${PASSWD}/g" /etc/nginx/conf.d/default.conf
RUN sed -i "s/gateway_url_tmp/${URL}/g" /etc/nginx/conf.d/default.conf
RUN sed -i "s/gateway_cookiebaseurl_tmp/${COOKIEBASEURL}/g" /etc/nginx/conf.d/default.conf