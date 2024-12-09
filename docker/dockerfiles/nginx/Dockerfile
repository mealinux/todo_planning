FROM nginx:1.27.3

WORKDIR /projects

RUN rm -rf /etc/nginx/conf.d/default.conf

RUN chmod -R 664 /projects
RUN chown 1000:1000 /projects

EXPOSE 6001