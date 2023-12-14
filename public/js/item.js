$(function() {
    $('#sort_by').change(function () {
        $('#form').submit();
    });
});

function deleteAlert(){
    if(window.confirm('本当に削除しますか？')){
        
    }else{
        return false;
    }
}