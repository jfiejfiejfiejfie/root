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
    document.getElementById('hidden1').style.visibility = 'visible';
  }
  function previewImage2(obj)
  {
    var fileReader = new FileReader();
    fileReader.onload = (function() {
      document.getElementById('preview2').src = fileReader.result;
    });
    fileReader.readAsDataURL(obj.files[0]);
    document.getElementById('hidden2').style.visibility = 'visible';
  }
  function previewImage3(obj)
  {
    var fileReader = new FileReader();
    fileReader.onload = (function() {
      document.getElementById('preview3').src = fileReader.result;
    });
    fileReader.readAsDataURL(obj.files[0]);
    document.getElementById('hidden3').style.visibility = 'visible';
  }
  function previewImage4(obj)
  {
    var fileReader = new FileReader();
    fileReader.onload = (function() {
      document.getElementById('preview4').src = fileReader.result;
    });
    fileReader.readAsDataURL(obj.files[0]);
    document.getElementById('hidden4').style.visibility = 'visible';
  }
  function previewImage5(obj)
  {
    var fileReader = new FileReader();
    fileReader.onload = (function() {
      document.getElementById('preview5').src = fileReader.result;
    });
    fileReader.readAsDataURL(obj.files[0]);
  }
  // function test(){
  //   alert("a");
  //   $.ajax({url:"name_generator.php", success:function(result){
  //     alert(result);
  //   }
  //   })
  // } 
  // function add(point){
    
  //   data="hidden" + String(point);
  //   alert(data);
  //   document.getElementById(data).style.visibility = 'visible';
  //   return $point;
  // }