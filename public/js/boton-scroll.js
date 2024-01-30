  // Cuando el usuario haga scroll hacia abajo 20px desde el inicio del documento, muestra el botón
  window.onscroll = function() {
  scrollFunction()
  };

  function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
  document.getElementById("myBtn").style.display = "block";
  } else {
  document.getElementById("myBtn").style.display = "none";
  }
  }

  // Cuando el usuario haga clic en el botón, se desplaza hacia arriba del documento
  function topFunction() {
  document.body.scrollTop = 0; // Para Safari
  document.documentElement.scrollTop = 0; // Para Chrome, Firefox, IE y Opera
  }
