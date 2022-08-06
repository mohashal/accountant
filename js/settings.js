/*------------- remove bank --------------*/
function remove_bank(id){
var c=confirm('هل تريد الحذف ؟');
if(c){mymodalbox("حذف البنك","ajax_settings.php?bank=delete_bank&id="+id+"",1);}
}

/*------------- remove currency --------------*/
function remove_currency(id){
var c=confirm('هل تريد الحذف ؟');
if(c){mymodalbox("حذف عملة","ajax_settings.php?currency=delete_currency&id="+id+"",1);}
}
/*------------- remove element --------------*/
function remove_element(id,type){
var c=confirm('هل تريد الحذف ؟');
if(c){mymodalbox("الحذف","ajax_settings.php?"+type+"=delete&id="+id+"",1);}
}

