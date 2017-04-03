jQuery(function(e){e.widget("blueimp.fileupload",e.blueimp.fileupload,{options:{imageMaxWidth:imageheight,imageMaxHeight:imagewidth}});function c(h,g,i){var j=e("#kbbcode-message").val();e("#kbbcode-message").insertAtCaret(" [attachment="+h+"]"+g+"[/attachment]");if(i!=undefined){i.removeClass("btn-primary");i.addClass("btn-success");i.html('<i class="icon-upload"></i> '+Joomla.JText._("COM_KUNENA_EDITOR_IN_MESSAGE"));}}jQuery.fn.extend({insertAtCaret:function(g){return this.each(function(k){if(document.selection){this.focus();sel=document.selection.createRange();sel.text=g;this.focus();}else{if(this.selectionStart||this.selectionStart=="0"){var j=this.selectionStart;var h=this.selectionEnd;var l=this.scrollTop;this.value=this.value.substring(0,j)+g+this.value.substring(h,this.value.length);this.focus();this.selectionStart=j+g.length;this.selectionEnd=j+g.length;this.scrollTop=l;}else{this.value+=g;this.focus();}}});}});var f=null;var b=null;e("#remove-all").on("click",function(g){g.preventDefault();e("#insert-all").removeClass("btn-success");e("#insert-all").addClass("btn-primary");e("#insert-all").html('<i class="icon-upload"></i>'+Joomla.JText._("COM_KUNENA_UPLOADED_LABEL_INSERT_ALL_BUTTON"));e("#remove-all").hide();e("#insert-all").hide();if(e.isEmptyObject(b)==false){e(b).each(function(i,j){if(e("#kattachs-"+j.id).length==0){e("#kattach-list").append('<input id="kattachs-'+j.id+'" type="hidden" name="attachments['+j.id+']" value="1" />');}if(e("#kattach-"+j.id).length>0){e("#kattach-"+j.id).remove();}e.ajax({url:kunena_upload_files_rem+"&fil_id="+j.id,type:"POST",success:function(k){e("#files").empty();}});});b=null;}var h=e("#kattach-list").find("input");h.each(function(j,k){var l=e(k);if(!l.attr("id").match("[a-z]{8}")){var m=l.attr("id").match("[0-9]{2}");if(e("#kattachs-"+m).length==0){e("#kattach-list").append('<input id="kattachs-'+m+'" type="hidden" name="attachments['+m+']" value="1" />');}if(e("#kattach-"+m).length>0){e("#kattach-"+m).remove();}e.ajax({url:kunena_upload_files_rem+"&fil_id="+m,type:"POST",success:function(i){e("#files").empty();}});}});f=0;});e("#insert-all").on("click",function(g){g.preventDefault();if(e.isEmptyObject(b)==false){e(b).each(function(i,j){c(j.id,j.name);});}b=null;var h=e("#kattach-list").find("input");h.each(function(l,m){var n=e(m);if(!n.attr("id").match("[a-z]{8}")){var k=n.attr("id").match("[0-9]{1,8}");var j=n.attr("placeholder");c(k,j);e("#insert-all").removeClass("btn-primary");e("#insert-all").addClass("btn-success");e("#insert-all").html('<i class="icon-upload"></i>'+Joomla.JText._("COM_KUNENA_EDITOR_IN_MESSAGE"));}});e("#files .btn.btn-primary").each(function(){e("#files .btn.btn-primary").addClass("btn-success");e("#files .btn.btn-success").removeClass("btn-primary");e("#files .btn.btn-success").html('<i class="icon-upload"></i>'+Joomla.JText._("COM_KUNENA_EDITOR_IN_MESSAGE"));});});var a=e("<button>").addClass("btn btn-primary").html('<i class="icon-upload"></i> '+Joomla.JText._("COM_KUNENA_EDITOR_INSERT")).on("click",function(k){k.preventDefault();k.stopPropagation();var j=e(this),i=j.data();var h=0;var g=null;if(i.result!=undefined){h=i.result.data.id;g=i.result.data.filename;}else{h=i.id;g=i.name;}c(h,g,j);});var d=e("<button/>").addClass("btn btn-danger").attr("type","button").html('<i class="icon-trash"></i> '+Joomla.JText._("COM_KUNENA_GEN_REMOVE_FILE")).on("click",function(){var i=e(this),h=i.data();e("#klabel_info_drop_browse").show();var g=0;if(h.uploaded==true){if(h.result!=false){g=h.result.data.id;}else{g=h.file_id;}}if(e("#kattachs-"+g).length==0){e("#kattach-list").append('<input id="kattachs-'+g+'" type="hidden" name="attachments['+g+']" value="1" />');}if(e("#kattach-"+g).length>0){e("#kattach-"+g).remove();}f=f-1;e.ajax({url:kunena_upload_files_rem+"&fil_id="+g,type:"POST",success:function(j){i.parent().remove();}});});e("#fileupload").fileupload({url:e("#kunena_upload_files_url").val(),dataType:"json",autoUpload:true,disableImageResize:/Android(?!.*Chrome)|Opera/.test(window.navigator.userAgent),previewMaxWidth:100,previewMaxHeight:100,previewCrop:true}).bind("fileuploadsubmit",function(h,g){var i={};e.each(g.files,function(j,k){i={catid:e("#kunena_upload").val(),filename:k.name,size:k.size,mime:k.type};});g.formData=i;}).bind("fileuploaddrop",function(i,h){e("#form_submit_button").prop("disabled",true);e("#insert-all").show();e("#remove-all").show();var g=Object.keys(h.files).length+f;if(g>kunena_upload_files_maxfiles){e('<div class="alert alert-danger"><button class="close" type="button" data-dismiss="alert">×</button>'+Joomla.JText._("COM_KUNENA_UPLOADED_LABEL_ERROR_REACHED_MAX_NUMBER_FILES")+"</div>").insertBefore(e("#files"));return false;}else{f=Object.keys(h.files).length+f;}}).bind("fileuploadchange",function(i,h){e("#form_submit_button").prop("disabled",true);e("#insert-all").show();e("#remove-all").show();var g=Object.keys(h.files).length+f;if(g>kunena_upload_files_maxfiles){e('<div class="alert alert-danger"><button class="close" type="button" data-dismiss="alert">×</button>'+Joomla.JText._("COM_KUNENA_UPLOADED_LABEL_ERROR_REACHED_MAX_NUMBER_FILES")+"</div>").insertBefore(e("#files"));return false;}else{f=Object.keys(h.files).length+f;}}).on("fileuploadadd",function(h,g){e("#progress .bar").css("width","0%");g.context=e("<div/>").appendTo("#files");e.each(g.files,function(i,j){var k=e("<p/>").append(e("<span/>").text(j.name));if(!i){k.append("<br>");}k.appendTo(g.context);});}).on("fileuploadprocessalways",function(k,j){var g=j.index,h=j.files[g],i=e(j.context.children()[g]);if(h.preview){i.prepend("<br>").prepend(h.preview);}if(h.error){i.append("<br>").append(e('<span class="text-danger"/>').text(h.error));}if(g+1===j.files.length){j.context.find("button.btn-primary").text(Joomla.JText._("COM_KUNENA_UPLOADED_LABEL_UPLOAD_BUTTON")).prop("disabled",!!j.files.error);}}).on("fileuploaddone",function(j,i){var h=e("<a>").attr("target","_blank").prop("href",i.result.location);i.context.find("span").wrap(h);if(i.result.success==true){e("#form_submit_button").prop("disabled",false);e("#kattach-list").append('<input id="kattachs-'+i.result.data.id+'" type="hidden" name="attachments['+i.result.data.id+']" value="1" />');e("#kattach-list").append('<input id="kattach-'+i.result.data.id+'" placeholder="'+i.result.data.filename+'" type="hidden" name="attachment['+i.result.data.id+']" value="1" />');i.uploaded=true;i.context.append(a.clone(true).data(i));if(i.context.find("button").hasClass("btn-danger")){i.context.find("button.btn-danger").remove();}i.context.append(d.clone(true).data(i));}else{if(i.result.message){e("#form_submit_button").prop("disabled",false);i.uploaded=false;i.context.append(d.clone(true).data(i));var g=null;e.each(i.result.data.exceptions,function(l,k){k=e('<div class="alert alert-error"/>').text(k.message);i.context.find("span").append("<br>").append(k);});}}}).on("fileuploadfail",function(h,g){e.each(g.files,function(j,k){var i=e('<span class="text-danger"/>').text("File upload failed.");e(g.context.children()[j]).append("<br>").append(i);});}).prop("disabled",!e.support.fileInput).parent().addClass(e.support.fileInput?undefined:"disabled");if(e("#kmessageid").val()>0){e.ajax({type:"POST",url:kunena_upload_files_preload,async:false,dataType:"json",data:{mes_id:e("#kmessageid").val()},success:function(g){if(e.isEmptyObject(g.files)==false){f=Object.keys(g.files).length;b=g.files;e(g.files).each(function(i,j){var k="";if(j.image===true){k='<img src="'+j.path+'" width="100" height="100" /><br />';}else{k='<i class="icon-flag-2 icon-big"></i><br />';}var h=e("<div><p>"+k+"<span>"+j.name+"</span><br /></p></div>");g.uploaded=true;g.result=false;g.file_id=j.id;h.append(a.clone(true).data(j));h.append(d.clone(true).data(g));h.appendTo("#files");});}}});}});