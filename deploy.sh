#!/bin/bash

#
# Prepare environment
#
source $HOME/deploy.env
cd $WORKDIR
export LOG_DATE=`date +'%Y-%m-%d_%H:%M:%S'`
export LOG_NAME=$HOME/deploy/log/deploy.log_$LOG_DATE

#
# Check lockfile
#
git config --global alias.up '!git remote update -p; git merge --ff-only @{u}'
echo -e "\n\nProduction application deployment initiated @ $LOG_DATE\n\n" | tee $LOG_NAME
if [ -a $HOME/deploy/deploy.lock ]; then
  echo -e "\nLock file exists. Halting deploy\n" | tee -a $LOG_NAME
  mail -s "Deploy Failed for michaelbilberry.com" admin@michaelbilberry.com < $LOG_NAME
  exit 1
else
  echo -e "\nLock file does not exist. Moving forward with deploy\n" | tee -a $LOG_NAME
  touch $HOME/deploy/deploy.lock
fi

#
# Deploy repository to web server (+backup/cleanup)
#
git up | tee -a $LOG_NAME
if [ $? -ne 0 ]; then
  mail -s "Deploy Failed for michaelbilberry.com" admin@michaelbilberry.com < $LOG_NAME
  exit 1
else
  cp -r $HOME/website $HOME/deploy/backup/website_$LOG_DATE
  find $HOME/deploy/backup/ -type f -mtime +90 -exec rm {} \;
  find $HOME/deploy/backup/ -type f -mtime +2 -exec gzip {} \;
  echo -e "$WORKDIR/.git/\n$WORKDIR/deploy.sh\n$WORKDIR/README.md" > $HOME/deploy/deploy.excluded_files
  rsync -ithv $WORKDIR/ $HOME/ | tee -a $LOG_NAME
  if [ $? -ne 0 ]; then
     mail -s "Deploy Failed for michaelbilberry.com" admin@michaelbilberry.com < $LOG_NAME
     exit 1
  else
  rm -rf $HOME/deploy/deploy.lock
  fi
fi
rm -rf $HOME/deploy/deploy.excluded_files

#
# Post deploy smoke test
#
echo -e "\nDeploy complete. Running smoke test via curl\n" | tee -a $LOG_NAME 
curl http://www.michaelbilberry.com > $HOME/deploy/log/deploy_smoke_test.html
SUCCESS=`cat $HOME/deploy/log/deploy_smoke_test.html | grep SUCCESS | wc -l`
if [ "$SUCCESS" -gt 0 ]; then
  echo -e "\nSmoke test complete. All systems nominal\n" | tee -a $LOG_NAME
  exit 0
else
  echo -e "\nIt's the end of the world as we know it!\n" | tee -a $LOG_NAME
  mail -s "Deploy Failed for michaelbilberry.com" admin@michaelbilberry.com < $LOG_NAME
  exit 1
fi

exit

