/*********** Blog delete **********/
function drop(id, userid)
{
    msg = confirm('Are you sure to delete blog?');
    //let the value encoded before pass in url
    var blogid = btoa(id);
    var user = btoa(userid);
    //let the value uri encoded
    var encodeid = encodeURIComponent(blogid);
    var encodeuser = encodeURIComponent(user);
  
    if (msg == true) 
    {
      window.location.href = base_url+'blog/delete/'+ encodeid + '/' + encodeuser;
    }
}

/************** Blog edit *************/
function edit(id, userid)
{
    msg = confirm('Do you wanna really edit?');
    //encoding the value
    var blogid = btoa(id);
    var user = btoa(userid);
    //uri encoding
    var encodeid = encodeURIComponent(blogid);
    var encodeuser = encodeURIComponent(user);

    if(msg == true)
    {
      window.location.href = base_url+'blog/update/'+ encodeid + '/' + encodeuser;
    }   
}

/********* Read more functionality*************/
function readMore(id)
{

  //variable with value of elements used in blog
  var dots = document.getElementById(id+"d");
  var button = document.getElementById(id+"b");
  var halfText = document.getElementById(id+"h");
  var fullText = document.getElementById(id+"f");

 console.log(dots);
 console.log(button);
 console.log(halfText);
 console.log(fullText);

  if (dots.style.display != 'none') 
  {
      
      fullText.style.display = 'inline-block';
      halfText.style.display = 'none';
      button.innerHTML = 'Read less...';
      dots.style.display = 'none';
  }

  else
  {
      
      fullText.style.display = 'none';
      halfText.style.display = 'inline-block';
      button.innerHTML = 'Read more';
      dots.style.display = 'inline';
  }
  var x = fullText.style.display;
}

/******** file delete ************/
function file_drop(id,name)
{
  msg = confirm('Are you sure to delete file?');
  var blogid = id;
  var fileloc = './uploads/'+name;

  //let the value encoded before pass in url
  var encodeid = btoa(blogid);
  var encodeloc = btoa(fileloc);

  //let the value uri encoded
  var blogid = encodeURIComponent(encodeid);
  var fileloc = encodeURIComponent(encodeloc);

  console.log(msg);
  if (msg == true) 
  {
    window.location = base_url+'file/file_delete/'+ blogid + '/' + fileloc;
  }
}

/*********** Blog delete **********/
function drop_profile()
{
    msg = confirm('Are you sure to delete profile?');
  
    if (msg == true) 
    {
      window.location.href = base_url+'profile/delete_profile';
    }
}

