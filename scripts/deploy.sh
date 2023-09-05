#!/bin/bash
cd /home/ubuntu/app/circleci/hyungseok && aws s3 cp s3://hyungseoks-deploy2/.env.prod ./.env && docker-compose up -d --force-recreate
