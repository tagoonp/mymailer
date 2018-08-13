var config = {
  ws_url: 'http://localhost/public_html/mymailer/controller/',
  root_domain: 'http://localhost/public_html/mymailer/',
  prefix: 'arsa18_'
}

var main = {
  init: function(){
    $w = $(document).width()
    if($w > 500){
      console.log($w);
      $('.navbar, .main-panel').css('padding-left', '260px')
    }
  },
  signout: function(){
    window.localStorage.removeItem(config.prefix + 'uid')
    window.location = '../'
  }
}
