FROM nginx:alpine
COPY default.conf /etc/nginx/conf.d/
COPY wait-for-app.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/wait-for-app.sh
CMD ["/usr/local/bin/wait-for-app.sh", "nginx", "-g", "daemon off;"]