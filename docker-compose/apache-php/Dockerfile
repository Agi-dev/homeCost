FROM feelpix/apache-php-dev

# Uncomment the following lines and enter the host user UID if necessary
RUN change-dev-id 501

ENV STORE_ADDRESS=localhost.homecost.com

# Install the php packages
RUN apt-get update &&\
    apt-get install -y php5-dev php5-curl php5-mcrypt php5-gd php5-mysql phpmyadmin &&\
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Mcrypt
RUN php5enmod mcrypt

# Add and enable virtualhost and enable rewrite mod
COPY /apache/homecost.conf /etc/apache2/sites-available/homecost.conf
RUN sed -i -e "s/{{STORE_ADDRESS}}/$STORE_ADDRESS/" /etc/apache2/sites-available/homecost.conf &&\
    a2ensite homecost && a2enmod rewrite

# add default command to start the container
COPY /bin/start-service /usr/local/bin/start-service
RUN chmod +x /usr/local/bin/start-service

USER dev

CMD ["start-service"]