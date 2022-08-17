from typing import Counter
from django.shortcuts import render, HttpResponse,redirect
from os import listdir
from os.path import isfile, join
from django.shortcuts import render
from django.views.generic.base import TemplateView
from .forms import MyfileUploadForm
from .models import file_upload
from .models import FileModel
from myproj import settings


def index(request):
    file_upload.objects.all().delete()
    all_data = file_upload.objects.all()
    media_path = settings.MEDIA_ROOT
    myfiles = [f for f in listdir(media_path) if isfile(join(media_path, f))]

    for a in range(len(myfiles)):
               
                file_upload( my_file=myfiles[a]).save()
               
                
    
    
    if request.method == 'POST':
        form = MyfileUploadForm(request.POST, request.FILES)


        print(form.as_p)
        
        if form.is_valid():
            the_files = form.cleaned_data['files_data']
            the_files = form.files.getlist('files_data')
            for i in the_files:
                 file_upload( my_file=i).save()

           
            
            return HttpResponse("file upload")
        else:
            length=[]
            all_data = file_upload.objects.all()
            the_files = form.files.getlist('files_data')
            for i in the_files:
                 file_upload( my_file=i).save()
                 b = i
                 length.append(b)
            context = {
                'filedata':the_files,
                'data':all_data,
                'len':length
            }
            return render(request,'uploaded.html',context)

    else:
        if 'q' in request.GET:
            q= request.GET['q']
            all_data = file_upload.objects.filter(my_file__icontains=q)
            numof = len(all_data)
            context = {
            'form':MyfileUploadForm(),
            'datas':myfiles ,
            'data': all_data,
            'no_files':numof
           }    
            return render(request, 'index.html', context)
        else:
             all_data = file_upload.objects.all()
        numof = len(myfiles)
        context = {
            'form':MyfileUploadForm(),
            'datas':myfiles ,
            'data': all_data,
            'no_files':numof
        }      
        
        return render(request, 'index.html', context)
        



# def show_file(request):
#     # this for testing 
#     media_path = settings.MEDIA_ROOT
#     myfiles = [f for f in listdir(media_path) if isfile(join(media_path, f))]
#     context={
#         'datas':  myfiles,
#         'data': media_path
#     }

#     return render(request, 'view.html', context)
    


    

