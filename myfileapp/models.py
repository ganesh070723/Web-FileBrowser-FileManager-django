from django.db import models
from myproj import settings
# Create your models here.

class file_upload(models.Model):
    ids = models.AutoField(primary_key=True)
    my_file = models.FileField(upload_to='')
    
    
    def __str__(self):
        return self.my_file
    
class FileModel(models.Model):
    ids = models.AutoField(primary_key=True)
    file = models.FileField(null=True, blank=True)
    timestamp = models.DateTimeField(auto_now_add=True)
    path = models.FilePathField(path=settings.MEDIA_ROOT, default=settings.MEDIA_ROOT)