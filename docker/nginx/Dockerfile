FROM nginx as praga_frontend

RUN apt-get update && apt-get install -y nodejs npm git && npm install npm@latest -g && mkdir -p /nonexistent && chown -R nginx:nginx /nonexistent && mkdir -p /app/frontend

WORKDIR /app/frontend

COPY app /app
COPY /app/frontend /app/frontend
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx/conf /etc/nginx/conf.d

RUN npm install && npm run build && chown -R nginx:nginx /app/frontend

EXPOSE 80:80
