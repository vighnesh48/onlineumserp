function addMaster(module,uri)
{

    window.location.href =uri;
}
function viewMaster(module,uri,id)
{
    window.location.href =uri+"/"+id;
}
function deleteMaster(module,uri,id)
{
    if(confirm('Do you want to delete this record?'))
    {
        window.location.href =uri+"/"+id;
    }
}
function editMaster(module,uri,id)
{
    window.location.href =uri+"/"+id;
}
function searchMaster(module,uri)
{
    val = $("#txtSearch").val();
    if(val=="")
    {
        alert("Please Enter Search Value.");
        return false;
    }
    document.getElementById('hdnSearch').value = "1";
    //alert(document.getElementById('hdnSearch').value);
    document.frmListView.action = uri
    document.forms["frmListView"].submit();
}