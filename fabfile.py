# Default environments for testing, staging and production are included.
from girru.environments import *

# This is specific to Django projects
env.project = ''

# You can specify environments here

#def production():
#    env.hosts = [default_production_server]
#    env.path = '/var/www/example.com':tabnext
#

def production():
    env.hosts = [default_production_server]
    env.path = '/var/www/music.simoncampbell.com/'
# 
# def staging():
#     env.hosts = [default_staging_server]
#     env.path = '/var/www/simoncampbellmusic.erskinestage.com/'
# 
# def testing():
#     env.hosts = [default_testing_server]
#     env.path = '/var/www/simoncampbellmusic.erskinedev.com/'

# Do not modify below this line
from girru.operations import *
