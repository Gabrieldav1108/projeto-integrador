FROM nginx:alpine

COPY nginx.conf /etc/nginx/conf.d/default.conf
COPY wait-for-app.sh /wait-for-app.sh
RUN chmod +x /wait-for-app.sh

ENTRYPOINT ["/wait-for-app.sh"]