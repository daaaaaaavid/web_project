var tool = new Tool();
window.addEventListener("DOMContentLoaded", () => {
  add_template_event();
});

function add_template_event(){

  let items = document.getElementsByClassName("template"), current = null;

  for(let i of items){
    i.draggable = true;
    i.ondragstart = (ev) => {
      if(i.id=="text-only")
        ev.dataTransfer.setData("type","text-only");
      else if(i.id=="image-only")
        ev.dataTransfer.setData("type","image-only");
      else if(i.id=="image-text")
        ev.dataTransfer.setData("type","image-text");
      else if(i.id=="text-image")
        ev.dataTransfer.setData("type","text-image");

      var blocks_end = document.createElement("div");

      blocks_end.className = "block" ;
      current = blocks_end;
      blocks_end.classList.add("block_end");
      document.getElementById("sortlist").appendChild(blocks_end);
      // blocks_end.ondragstart = (ev) =>{
      //   ev.preventDefault();
      // };
      blocks_end.draggable = "true";
      blocks_end.ondragstart = (ev) =>{
        blocks_end.classList.add("block_move");
      }
      blocks_end.ondragend = (ev) =>{
        blocks_end.classList.remove("block_move");
      }
      add_block_event();

      let blocks = document.getElementsByClassName("block");
      for(let j of blocks){
        j.classList.add("hint");
      }
    }

    i.ondragend = (ev) =>{
      let blocks = document.getElementsByClassName("block");
      for(let j of blocks){
        j.classList.remove("hint");
      }
      let block_end = document.getElementsByClassName("block_end")[0];
      if(block_end){
        document.getElementById("sortlist").removeChild(block_end);
      }
    }
  }

}
function add_block_event(){
  let blocks = document.getElementsByClassName("block");

  for(let i of blocks){

    i.ondragenter = (ev) =>{
      i.classList.add("active");
    }
    i.ondragleave = (ev) =>{
      i.classList.remove("active");
    }
    i.ondragover = (ev) =>{
      ev.preventDefault();
    }
    i.ondrop = (ev) =>{
      ev.preventDefault();

      let current = document.getElementsByClassName("block_end")[0];
      let items = document.getElementsByClassName("block");
      if (!current){
        current = document.getElementsByClassName("block_move")[0];
        let currentpos = -1, droppedpos = -1;
        for (let it=0; it<items.length; it++) {
          if (current == items[it]) { currentpos = it; }
          if (i == items[it]) { droppedpos = it; }
        }

        if (currentpos < droppedpos) {
          i.parentNode.insertBefore(current, i.nextSibling);
        } else {
          i.parentNode.insertBefore(current, i);
        }
      }
      else if (i != current) {
        let currentpos = -1, droppedpos = -1;
        for (let it=0; it<items.length; it++) {
          if (current == items[it]) { currentpos = it; }
          if (i == items[it]) { droppedpos = it; }
        }

        if (currentpos < droppedpos) {
          i.parentNode.insertBefore(current, i.nextSibling);
        } else {
          i.parentNode.insertBefore(current, i);
        }
      }
      current.classList.remove("block_end");
      i.classList.remove("active");
      let num = tool.get_item("block_id");
      if(ev.dataTransfer.getData("type")=="text-only") {
        
        current.id = num+"_textonly";
        current.contentEditable = "true";
        
        initial_btn_function_textonly(current.id);

        current.addEventListener('paste', function(e){
            e.preventDefault();
            var text = (e.originalEvent || e).clipboardData.getData('text/plain');
            document.execCommand("insertHTML", false, text);
        })
      }
      else if(ev.dataTransfer.getData("type")=="image-only"){
        current.id = num +"_imageonly";

        let image_parent = document.createElement("div");
        image_parent.classList.add("block_image");
        image_parent.id = num + "_image";

        let replace_img = document.createElement('img');
        replace_img.src = 'img-block.png';
        replace_img.setAttribute('class', 'camera-icon');
        replace_img.id = '#replace-' + num.toString();

        image_parent.appendChild(replace_img);
        current.appendChild(image_parent);

        image_parent.addEventListener('click', function(){
          initial_btn_function_imgonly(num + "_imageonly");
        })
        

        initial_btn_function_imgonly(num + "_imageonly");
      }
      else if(ev.dataTransfer.getData("type")=="image-text"){
        current.id = num +"_imageonly";

        let text_block = document.createElement("div");
        text_block.id = num + "_text";
        text_block.contentEditable = "true";
        text_block.classList.add("block_text");
        text_block.ondragstart = (ev)=>{
          ev.preventDefault();
        }
        text_block.addEventListener("click",function(){
          initial_btn_function_textonly(current.id);
          
        })

        let image_parent = document.createElement("div");
        image_parent.classList.add("block_image");
        image_parent.id = num + "_image";

        let replace_img = document.createElement('img');
        replace_img.src = 'img-block.png';
        replace_img.setAttribute('class', 'camera-icon');
        replace_img.id = '#replace-' + num.toString();

        image_parent.appendChild(replace_img);

        current.appendChild(image_parent);
        image_parent.addEventListener('click', function(){
          initial_btn_function_imgonly(num + "_imageonly");
        })

        
        initial_btn_function_imgonly(num + "_imageonly");
        current.classList.add("image_text");
        current.appendChild(text_block);
        
      }
      else if(ev.dataTransfer.getData("type")=="text-image"){
        current.id = num +"_imageonly";

        let text_block = document.createElement("div");
        text_block.id = num + "_text";
        text_block.contentEditable = "true";
        text_block.classList.add("block_text");
        text_block.ondragstart = (ev)=>{
          ev.preventDefault();
        }
        text_block.addEventListener("click",function(){
          initial_btn_function_textonly(current.id);
        })
        current.appendChild(text_block);

        
        initial_btn_function_textonly();

        let image_parent = document.createElement("div");
        image_parent.classList.add("block_image");
        image_parent.id = num + "_image";

        let replace_img = document.createElement('img');
        replace_img.src = 'img-block.png';
        replace_img.setAttribute('class', 'camera-icon');
        replace_img.id = '#replace-' + num.toString();

        image_parent.appendChild(replace_img);

        image_parent.addEventListener('click', function(){
          initial_btn_function_imgonly(num + "_imageonly");
        })

        current.appendChild(image_parent);
        initial_btn_function_imgonly(num + "_imageonly");
        current.classList.add("image_text");

      }
      current.addEventListener('click', function(){
        if(this.id.includes('textonly')){
          initial_btn_function_textonly(current.id);
        }
        else if(this.id.includes('imageonly') && document.getElementById(this.id).children.length <= 1){
          initial_btn_function_imgonly(this.id);
        }
      })
    }
  }
}


  