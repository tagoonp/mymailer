var current_user = window.localStorage.getItem(config.prefix + 'uid')

var repository = {
  create_repo: function(id){
    var param = {
      email: $('#txtRepoemail').val(),
      password: $('#txtRepopassword').val(),
      mailer_name: $('#txtReposender').val(),
      uid: id
    }

    var jxr = $.post(config.ws_url + 'add-repository.php', param, function(){})
               .always(function(resp){
                  if(resp != 'Y'){
                    alert('error')
                  }
                  $('.btnCloseModal').trigger('click')
                  repository.load_email_repo(current_user)
                  preload.hide()
               })
               .fail(function(){
                 main.error_log()
               })
  },
  load_email_repo: function(id){
    var param = {
      uid: ''
    }
    if(id != null){
      param = {
        uid: id
      }
    }

    var jxr = $.post(config.ws_url + 'list-repository.php', param, function(){}, 'json')
               .always(function(snap){
                 if(fnc.checksnap(snap)){
                   $('#repoSpan').empty()
                   snap.forEach(function(i){
                     var active_status = '<span class="text-success" style="cursor:pointer;" onclick="toggleRepo(\'' + i.ea_id + '\', \'' + i.ea_status + '\')"><i class="fas fa-check"></i></span>'
                     var mail_status = '<span class="text-muted">Click "Test" for check sending email</span>'
                     if(i.ea_mailer_status == '1'){
                       mail_status = '<span class="text-success">Normal</span>'
                     }else if(i.ea_mailer_status == '0'){
                       mail_status = '<span class="text-danger">Failed</span>'
                     }


                     if(i.ea_status == '0'){
                       active_status = '<span class="text-danger" style="cursor:pointer;" onclick="toggleRepo(\'' + i.ea_id + '\', \'' + i.ea_status + '\')"><i class="fas fa-times"></i></span>'
                     }
                     $data = '<div class="card mb-10">' +
                               '<div class="card-body" style="background: rgb(255, 255, 255);">' +
                                   '<div class="th_font text-dark fs12">API KEY :</div>' +
                                   '<h4 class="card-title th_font fs15 fw400 mb-0" >' + i.ea_keyemail + '</h4>' +
                                   '<div class="th_font text-danger fs12"><span class="text-dark">Create</span> : ' + i.ea_regdatetime + '</div>' +
                                   '<div class="row pt-20">' +
                                     '<div class="col-3 th_font pb-10">Sender\'s name :</div>' +
                                     '<div class="col-8 th_font pb-10">' + i.ea_mailername + '</div>' +
                                     '<div class="col-3 th_font pb-10">E-mail :</div>' +
                                     '<div class="col-8 th_font pb-10">' + i.ea_email + '</div>' +
                                     '<div class="col-3 th_font pb-10">Password :</div>' +
                                     '<div class="col-8 th_font pb-10">' + i.ea_password + '</div>' +
                                     '<div class="col-3 th_font pb-10">Active status :<br><small>Click to toggle</small></div>' +
                                     '<div class="col-3 th_font pb-10">' + active_status + '</div>' +
                                     '<div class="col-3 th_font pb-10">Mailer status :</div>' +
                                     '<div class="col-3 th_font pb-10">' + mail_status + '</div>' +
                                   '</div>' +
                               '</div>' +
                               '<div class="mdb-color_ lighten-3 text-center" style="background: rgb(255, 255, 255);">' +
                                   '<div class="row th_font" style="border: solid; border-width: 1px 0px 0px 0px; border-color: rgb(236, 236, 236); padding-top: 15px; padding-bottom: 15px;">' +
                                     '<div class="col text-center">' +
                                       '<a href="" class="text-dark" style="font-size: 0.9em;"><i class="fas fa-pencil-alt text-dark"></i> Edit</a>' +
                                     '</div>' +
                                     '<div class="col text-center">' +
                                       '<a href="" class="text-dark" style="font-size: 0.9em;"><i class="fas fa-sync-alt text-dark"></i> Test</a>' +
                                     '</div>' +
                                     '<div class="col text-center">' +
                                       '<a href="" class="text-dark" style="font-size: 0.9em;"><i class="fas fa-book text-dark"></i> How to</a>' +
                                     '</div>' +
                                     '<div class="col text-center">' +
                                       '<a href="" class="text-dark" style="font-size: 0.9em;" onclick="deleteRepo(\'' + i.ea_id + '\')"><i class="fas fa-trash text-dark"></i> Delete</a>' +
                                     '</div>' +
                                   '</div>' +
                               '</div>' +
                           '</div>'
                      $('#repoSpan').append($data)
                   })
                   setTimeout(function(){
                     preload.hide()
                   }, 1000)
                 }else{
                   $data = '<div class="row">' +
                              '<div class="col-sm-12 pt-30">' +
                                'No repository' +
                              '</div>'
                           '</div>'
                   $('#repoSpan').append($data)
                   preload.hide()
                 }
               })
               .fail(function(){
                 preload.hide()
               })
  }
}


function toggleRepo(repo_id, curr_stage){
  preload.show()
  var n = '1'
  if(curr_stage == '1'){
    n = '0'
  }
  var param = {
    id: repo_id,
    next_stage: n
  }
  var jxr = $.post(config.ws_url + 'toggle-repository-status.php', param, function(){})
             .always(function(resp){
               repository.load_email_repo(current_user)
             })
}


function deleteRepo(repo_id){
  var r = confirm("Warning! you can not recover this record after delete.");
  if (r == true) {
    preload.show()
    var param = {
      id: repo_id
    }
    var jxr = $.post(config.ws_url + 'delete-repository.php', param, function(){})
               .always(function(resp){
                 repository.load_email_repo(current_user)
               })
  }
}
