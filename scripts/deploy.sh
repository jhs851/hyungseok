#!/bin/bash
cd /home/ubuntu/app/codeship/hyungseok && aws s3 cp s3://hyungseok-webservices-deploy/.env.prod ./.env && docker-compose up -d --force-recreate
