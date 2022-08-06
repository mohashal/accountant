function select_to_url(){
var area= document.getElementById("area").value;
var resta=document.getElementById('restaurant').value;
if(area!=='' && resta!==''){
var replace = document.getElementById('search_submit');
replace.outerHTML="<a id='search_submit' href='search/"+area+"/"+resta+"/1.html'>[</a>";
}

}