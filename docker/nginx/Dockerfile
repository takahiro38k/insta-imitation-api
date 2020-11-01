FROM nginx
RUN apt-get update && apt-get install -y \
  less \
  # lessの日本語文字化けを抑止
  && echo "export LESSCHARSET=utf-8" >> ~/.bashrc
