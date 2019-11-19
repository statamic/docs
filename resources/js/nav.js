// Close sidebar (mobile)
  $(document).on('click', '#sidebar-close', function () {
    $('#side-nav').addClass('hidden')
    $('#sidebar-close').addClass('hidden')
    $('#sidebar-open').removeClass('hidden')
    $('#content').removeClass('overflow-hidden max-h-screen fixed')
  })

  // Show sidebar (mobile)
  $(document).on('click', '#sidebar-open', function () {
    $('#sidebar-open').addClass('hidden')
    $('#side-nav').removeClass('hidden')
    $('#sidebar-close').removeClass('hidden')
    $('#content').addClass('overflow-hidden max-h-screen fixed')
  })
