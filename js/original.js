function suteki(){
    audio.src='mp3/suteki.mp3';
    audio.play();
}
function rikki(){
    n=Math.random();
    if (n>0.9){
    audio.src='mp3/gen.mp3';
    audio.play();
    }
    else if(n>0.7){
    audio.src='mp3/偽物.mp3';
    audio.play();
    }
    else{
    audio.src='mp3/suteki.mp3';
    audio.play();
    }
}
function final(){
    audio.src='mp3/Final.mp3';
    audio.play();
}
$(function(){
  
    //カーソル要素の指定
    var cursor=$("#cursor");
    
    //mousemoveイベントでカーソル要素を移動させる
    $(document).on("mousemove",function(e){
      //カーソルの座標位置を取得
      var x=e.clientX;
      var y=e.clientY;
      //カーソル要素のcssを書き換える用
      cursor.css({
        "opacity":"1",
        "top":y+"px",
        "left":x+"px"
      });
    });
  });
  function previewImage(obj)
  {
    var fileReader = new FileReader();
    fileReader.onload = (function() {
      document.getElementById('preview').src = fileReader.result;
    });
    fileReader.readAsDataURL(obj.files[0]);
  }
  function checkdiv( obj,id ) {
    if( obj.checked ){
    document.getElementById(id).style.display = "block";
    }
    else {
    document.getElementById(id).style.display = "none";
    }
    }