from django import forms


class MyfileUploadForm(forms.Form):
    file_name = forms.CharField(widget=forms.TextInput(attrs={'class': 'form-control','multiple': True}))
    files_data = forms.FileField(widget=forms.FileInput(attrs={'class':'form-control','multiple': True}))