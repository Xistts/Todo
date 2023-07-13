const { forEach } = require("lodash");

$(document).ready(function() {
   // CREATE
   $("#btn-save").click(function (e) {
      let token = jQuery('meta[name="csrf-token"]').attr('content')
       $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': token
           }
       });
      e.preventDefault();
      var formData = new FormData();
      formData.append('image', jQuery('input[name="image"]')[0].files[0]);
      formData.append('title', jQuery('input[name="title"]').val());
      formData.append('keywords', jQuery('input[name="keywords"]').val());
      formData.append('description', jQuery('textarea[name="description"]').val());
      formData.append('ajax', jQuery('input[name="ajax"]').val());
       var type = "POST";
       var url = '/store';
       $.ajax({
           type: type,
           url: url,
           cache: false,
			   contentType: false,
			   processData: false,
			   data: formData,
			   dataType : 'json',
          success: function (data) {
             let image = '',
                completed = 'Завершено',
                keywords = ''
             data.data.keywords.split(",").forEach(el => {
               keywords += `<label class="inner btn-sm btn-info">${el}</label>`
             })
             if (data.data.image) {
                image = `<a class="" href="/${data.data.id}/edit"><img src="/images/thumbnail/${data.data.image}" width="150px"></a>`
             }
             if (data.data.is_completed==1) {
                completed = <a class="btn btn-sm btn-success" href="">Завершено</a>
             } else {
               completed = <a class="btn btn-sm btn-danger" href="">В работе</a>
             }

             var todo = `
             <tr id="${data.data.id}">
               <td>${data.data.title}</td>
               <td>${data.data.description}</td>
               <td>
                  ${image}
               </td>
               <td id="outer">
                  ${keywords}
               </td>
               <td id="completed-${data.data.id}">
                  ${completed}
               </td>
               <td id="outer">
                  <a class="inner btn btn-sm btn-success" href="/show/">Просмотр</a>
                  <a class="inner btn btn-sm btn-info" href="/${data.data.id}/edit">Редактирование</a>
                  <form action="/destroy" class="inner">
                     <input type="hidden" name="_token" value="${token}">
                     <input type="hidden" name="_method" value="Удалить">
                     <input type="hidden" name="todo_id" value="${data.data.id}">
                     <input id="btn-delete" type="submit" class="btn btn-sm btn-danger" value="удалить">
                  </form>
               </td>
            </tr>
            `;
               jQuery('input[name="title"]').val('');
               jQuery('input[name="image"]').val('');
               jQuery('input[name="keywords"]').val('');
               jQuery('textarea[name="description"]').val('');
               jQuery('.table tbody').append(todo);
               alert(data.message);
           },
           error: function (data) {
            alert(data.message);
           }
       });
   });
   // DELETE
   $('tr').on('submit', 'form', function (e) { 
      var t = $(this);
      let token = jQuery('meta[name="csrf-token"]').attr('content')
       $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': token
           }
       });
      e.preventDefault();
      var id = t.find('input[name="todo_id"]').val()
      var formData = {
         todo_id: id,
         ajax: 'ajax'
      };
       var type = "DELETE";
       var url = '/destroy';
       $.ajax({
           type: type,
           url: url,
			   data: formData,
			   dataType : 'json',
          success: function (data) {
               document.getElementById(id).remove();
               alert(data.message);
           },
           error: function (data) {
            alert(data.message);
           }
       });
   });
   // COMPLETED
   $('body').on('click', '#btn-completed', function (e) { 
      let token = jQuery('meta[name="csrf-token"]').attr('content')
       $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': token
           }
       });
      e.preventDefault();
      let id = $(this).data('id'),
         completed = $(this).data('Завершено')
      var formData = {
         todo_id: id,
         is_completed: completed,
         ajax: 'ajax'
      };
       var type = "PUT";
       var url = '/update';
       $.ajax({
           type: type,
           url: url,
			   data: formData,
			   dataType : 'json',
          success: function (data) {
            let completed =''
            if (data.data.is_completed==1) {
               completed = <a class="btn btn-sm btn-success" href="">Завершено</a>
            } else {
              completed = <a class="btn btn-sm btn-danger" href="">В работе</a>
            }
               document.getElementById("Завершено"+id).innerHTML = completed;
               alert('Успешно! ' + data);
           },
           error: function (data) {
            alert(data.message);
           }
       });
   });

   // FILTER
   $('.filter-container').on('submit', 'form', function (e) { 
      var t = $(this);
      let token = jQuery('meta[name="csrf-token"]').attr('content')
       $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': token
           }
       });
      e.preventDefault();
      var user_ids = t.find('input[name="user_id"]').val()
      var title = t.find('input[name="title"]').val()
      var completed = t.find('select[name="Завершено"]').val()
      var tags = t.find('input[name="tags"]').val()
      var formData = {
         title: title,
         completed: completed,
         tags: tags
      };
       var type = "POST";
       var url = '/search';
       $.ajax({
           type: type,
           url: url,
			   data: formData,
			   dataType : 'json',
          success: function (data) {
             var todo = ''
             data.data.forEach(data => {
                let image = '',
                completed = 'Завершено',
                keywords = '',
                outer = '',
                users = data.id_user.split(",")
                data.keywords.split(",").forEach(el => {
                   keywords += `<label class="inner btn-sm btn-info">${el}</label>`
                })
                if (data.image) {
                   if (users.includes(user_ids)) {
                      image = `<a class="" href="/${data.id}/edit"><img src="/images/thumbnail/${data.image}" width="150px"></a>`
                   } else {
                     image = `<img src="/images/thumbnail/${data.image}" width="150px">`
                   }
                }
                if ( users.includes(user_ids)) {
                   outer =`<a class="inner btn btn-sm btn-info" href="/${data.id}/edit">Редактировать</a>
                   <form action="/destroy" class="inner">
                      <input type="hidden" name="_token" value="${token}">
                      <input type="hidden" name="_method" value="DELETE">
                      <input type="hidden" name="todo_id" value="${data.id}">
                      <input id="btn-delete" type="submit" class="btn btn-sm btn-danger" value="Удалитть">
                   </form>`
                }
                if (data.is_completed == 1) {
                   completed = <a class="btn btn-sm btn-success" href="">Завершено</a>
                } else {
                   completed = <a class="btn btn-sm btn-danger" href="">В работе</a>
                }

                todo += `
                  <tr id="${data.id}">
                  <td>${data.title}</td>
                  <td>${data.description}</td>
                  <td>
                     ${image}
                  </td>
                  <td id="outer">
                     ${keywords}
                  </td>
                  <td id="completed-${data.id}">
                     ${Завершено}
                  </td>
                  <td id="outer">
                     <a class="inner btn btn-sm btn-success" href="/show/${data.id}">просмотр</a>
                     ${outer}
                  </td>
               </tr>
               `;
             });
             jQuery('.table tbody tr').remove();
             jQuery('.table tbody').append(todo);

           },
           error: function (data) {
            alert(data.message);
           }
       });
   });
   
});