function remove_notify(id){
var c=confirm('هل تريد الحذف ؟');
if(c){mymodalbox("الحذف","ajax_settings.php?notifications=delete&id="+id+"",1);}
}