$( document ).ready(function() {
  const myFilter = function(predicate){
    const proxyArr = [];
    for(item of this){
      if(predicate(item)) {
        proxyArr.push(item);
      }
    }
    return proxyArr;
  }; // Создали саму функцию для массива
  Array.prototype.myFilter = myFilter; // Поместили ее в базовый прототип массива
  dropMenu();// Выпадающее меню в каталоге
  abortLink();// Отмена перехода по ссылка в каталоге на мобильных устройствах
  searchList();// TODO: дич которую надо переделать, чисто показуха
  jsMedia();// Необходимые изменения для адаптива
  mmenuToggle($("#menu"), $("#mmenu-icon"));//Mmenu init
  toggleCatalogLi();// Появление/скрытие элементов спика в каталоге
  catalogViewToggle(); // Переключение вида каталога( грид или список)
  initRangeSlider(document.getElementById('range'),document.getElementById('leftRange'),document.getElementById('rightRange')); // Инит рейнж слайдера
  togglePassword(); // Показать/Скрыть пароль в инпутах
  $('.mask').inputmask();// инит масок
  yandexMapInit($('.yandex-maps')); // Инит яндекс карт
  recentlyToggle(); // Изменения при показе/скрытии блока "Недавно просмотренные"
  formValidations (); // Валидации форм
    resetProductFilter(); // Сброс всех фильтров в каталоге
  var catalogSortProps = {
    templateResult: formatState,
    templateSelection: formatState,
    minimumResultsForSearch: Infinity
  };
  initSelect($('#catalogSort'), catalogSortProps);// Инит селекта сортировки в каталоге
  $(".photoswipe").jqPhotoSwipe({
    mainClass: 'pswp--minimal--dark',
    fullscreenEl: false,
    shareEl: false,
    bgOpacity: 0.85,
    tapToClose: true,
    tapToToggleControls: false
  }); // инит PhotoSwipe
  var sliderFirst =  $('.content__img');
  for (i = 0; i < sliderFirst.length; i++) {
    sliderFirst.each(function(){
      var num = i++;
      var sliderMain = $(this).attr('id', `${num}`);
      console.log( sliderMain);
    });
  }
});


// functions -------------------------------------------
function mmenuToggle(menu, icon){
  var $menu = menu.mmenu({
    navbar: {
      title: '',
    },
    "navbars": [
      {
        "position": "top",
        "content": [
          "<span class='mobile-menu__closer' uk-icon='icon: close; ratio: 1.2'></span>",
        ]
      }
    ]
  });
  var $icon = icon;
  var closer = $('.mobile-menu__closer');
  var api = $menu.data( "mmenu" );
  $icon.on( "click", function() {
    api.open();
  });

  closer.on( "click", function() {
    api.close();
  });

  api.bind( "open:start", function() {
    $('body').addClass('menu-open');
    $icon.addClass( "is-active" );
    api.closeAllPanels();
  });
  api.bind( "open:finish", function() {
    var offset = $( '.mm-panel_opened .mm-listview' ).outerHeight() + 55;
    $( '.mm-navbars_bottom' ).animate( { top: offset }, 100 );
    $icon.one( "click", function() {
      api.close();
    });
  });
  api.bind( "close:start", function() {
    $('body').removeClass('menu-open');
    $icon.removeClass( "is-active" );
    $icon.one( "click", function() {
      api.open();
    });
  });
}
function formValidations () {
  jQuery.validator.addMethod("number", function(value, element) {
    return this.optional(element) || /[0-9]/.test(value.substr(-1));
  }, "Номер введен не полностью");

  var personalInfo = { // Настройки валидации формы обратной связи
    ignore: '.ignore',
    onfocusout : function (element) {
      $(element).valid()
    },
    invalidHandler: function(event, validator){
      alert('Yoopss');
    },
    submitHandler: function(form) {
      alert('All right, dude');
    },
    errorClass: "uk-form-danger",
    validClass: "uk-form-success",
    rules: {
      email: {
        required: true,
        email: true,
      },
      phone: {
        number: true,
      }
    },
    messages: {
      email: {
        required: "Поле необходимо для заполнения",
        email: "Почта введена некорректно"
      },
      phone: {
        phone: "Телефон введен некорректно"
      }
    }
  };
  $( '#presonalForm').validate( personalInfo ); // Валидация формы изменения персональной информации
}
function recentlyToggle(){
  var toggler = $('#toggleRecently');
  UIkit.util.on( toggler , 'beforeshow', function (event, component) {
    var item = $(component.$el);
    item.html("Скрыть");
    item.closest('div').siblings().show();
  });
  UIkit.util.on( toggler , 'beforehide', function (event, component) {
    var item = $(component.$el);
    item.html("Показать");
    item.closest('div').siblings().hide();
  });
}
function moveOrderButtons(){
  var buttons = $('.cabinet__order-buttons');
  var destop = $('.cabinet__order-buttons-desktop');
  var mobile = $('.cabinet__accordion-number');
  var container;

  $(window).width() <= 640 ? container = mobile : container = destop;
  container.each(function(index, item){
    $(item).append(buttons[index])
  });
}
function togglePassword(){
  $('.passwordToggler').on('click', function(e){
    e.preventDefault();
    var input = $(this).siblings('input');
    var toggler = $(this);
    if(input.attr('type') === 'password'){
      input.attr('type', 'text');
      toggler.text('Скрыть');
    } else {
      input.attr('type', 'password');
      toggler.text('Показать');
    }
  })
}
function adaptSelect(){
  var outer = $('.select2-outer');
  var select = outer.children('.select2');
  select.width(outer.width());
}
function catalogViewToggle(){
  $('.toggle-list').on('click', function(e){
    e.preventDefault();
    let catalog = $('#catalogItems');
    if($(this).hasClass('list')){
      catalog.addClass('list');
    }else{
      catalog.removeClass('list');
    }
  });
}
function formatState (state) {
  if (!state.id) {
    return state.text;
  }
  // var baseUrl = "img";
  var $state = $(
    '<span><img src="' + state.element.dataset.img.toLowerCase() + '.svg" class="img-flag" /> ' + state.text + '</span>'
    // '<span><img src="' + baseUrl + '/' + state.element.dataset.img.toLowerCase() + '.svg" class="img-flag" /> ' + state.text + '</span>'
  );
  return $state;
};
function initSelect(select, props){
  select.select2(props);
}
function noLetters(input) {
  var value = input.val();
  var rep = /[-\.;":'a-zA-Zа-яА-Я]/;
    console.log(213, value, rep.test(value))
  // if (rep.test(value)) {
  //   value = value.replace(rep, '');
  //   input.val(value);
  // }
}
function initRangeSlider(obj,leftInput,rightInput){
  var slider = obj;
  if(slider){
    var input0 = leftInput;
    var input1 = rightInput;
    var inputs = [input0, input1];
    var minValue = +$(slider).data('min');
    var maxValue = +$(slider).data('max');
    var startValue = +$(slider).data('start');
    var endValue = +$(slider).data('end');
    noUiSlider.create(slider, {
      start: [startValue, endValue],
      connect: true,
      range: {
        'min': minValue ,
        'max': maxValue,
      }
    });
    slider.noUiSlider.on('update', function( values, handle ) {
      inputs[handle].value = Math.round(values[handle]);
    });
    function setSliderHandle(i, value) {
      var r = [null,null];
      r[i] = value;
      slider.noUiSlider.set(r);
    }

    inputs.forEach(function(input){
      $(input).on( 'input', function(){
        noLetters($(this));
      });
    });
    // Listen to keydown events on the input field.
    inputs.forEach(function(input, handle) {
      input.addEventListener('change', function(){
        setSliderHandle(handle, this.value);
      });
      input.addEventListener('keydown', function( e ) {
        var values = slider.noUiSlider.get();
        var value = Number(values[handle]);
        var steps = slider.noUiSlider.steps();
        var step = steps[handle];
        var position;
        switch ( e.which ) {
          case 13:
            setSliderHandle(handle, this.value);
            break;
          case 38:
            // Get step to go increase slider value (up)
            position = step[1];
            // false = no step is set
            if ( position === false ) {
              position = 1;
            }
            // null = edge of slider
            if ( position !== null ) {
              setSliderHandle(handle, value + position);
            }
            break;
          case 40:
            position = step[0];
            if ( position === false ) {
              position = 1;
            }
            if ( position !== null ) {
              setSliderHandle(handle, value - position);
            }
            break;
        }
      });
    });
  }
}
// function counter(){
//   $( '.counter__sing' ).on( 'click', function() {
//     var item = $( this );
//     var input = item.siblings( 'input' );
//     var value = +input.val();
//     item.hasClass( 'minus' ) ? value > 0 && ( value -= 1 ) : value+=1;
//     input.val( value );
//   });
// }
function toggleCatalogLi(){
  $( '.list-toggler' ).on( 'click', function(){
      $( this ).toggleClass( 'open' ).siblings( '.hidden' ).slideToggle();
  });
}
function jsMedia() {
    moveHeaderSearch();// Перенос поиска в шапке при адаптации
    adaptSelect();// Адаптцая ширины кастомного селекта
    moveBanners();// Перенос баннеров при адаптации
  moveOrderButtons();
  $( window ).resize( function(){
    moveHeaderSearch();// Перенос поиска в шапке при адаптации
    adaptSelect();// Адаптцая ширины кастомного селекта
    moveBanners();// Перенос баннеров при адаптации
    moveOrderButtons();
  })
}

function moveBanners(){
  var banners = $( '.main-banner' );
  var desktopWrap = $( '#bannersBlock' );
  var mobileWrap = $( '#newsAside' );
  var smallMobileWrap = $( '#bannersMobile' );

  if( $( window ).width() < 640  ){
    smallMobileWrap.append( banners );
  } else if( $( window ).width() < 960 ) {
    mobileWrap.after( banners );
  } else {
    desktopWrap.append( banners );
  }
}
function moveHeaderSearch() {

  var form = $( '#headerSearch' );
  var desktopWrap = $( '#headerSearchWrap' );
  var mobileWrap = $( '#mobileSearch' );

  if( $( window ).width() < 960 ){
    mobileWrap.append( form );
  } else {
    desktopWrap.append( form );
  }
}
function searchList() {
  var input = $( '.search__input' );
  var form = input.closest('form').find('.header__search-wrap');
  input.on( 'focus', function(){
    $.ajax({
      url:'../temp-search.html',
      type:'GET',
      success: function(data){
        var content = $(data).siblings('.search__list').clone();
        form.html(content);
      },
      error: function(error){
        console.log('Yoops');
      }
    });
  });
  input.on( 'focusout', function(){
    setTimeout(function(){
      form.find('ul').remove();
    }, 400);
  });
}
function dropMenu() {
  $( '.catalog-menu__li' ).hover( function(){
    $( this ).addClass( 'open' ).children( 'ul' ).addClass( 'open' );
  }, function(){
    $( this ).removeClass( 'open' ).children( 'ul' ).removeClass( 'open' );
  });
}

function abortLink(){
  $( '.catalog-menu__link:not(.last)' ).on( 'click', function( event ){
    if( $( window ).width() <= 1024 ){
      event.preventDefault();
      alert(123);
    }
  });
}

function yandexMapInit(items){

  $(items).each( function(){
    var mapId = $( this ).attr( 'id' );
    var address = $( this ).attr( 'data-address' );

    ymaps.ready(init);
    function init() {
      ymaps.geocode( address, { results: 1 }).then(function (res) {
        var coords = res.geoObjects.get(0).geometry.getCoordinates();
        var map = new ymaps.Map( mapId, {
          center: coords,
          zoom: 17
        });
        var placemark = new ymaps.Placemark(coords, {
          hintContent: 'Содержимое всплывающей подсказки',
          balloonContent: 'Содержимое балуна'
        },{
          iconLayout: 'default#image',
          // iconImageHref: '/img/gps.svg',
          iconImageSize: [42, 57],
          iconImageOffset: [-20, -60]
        });
        map.geoObjects.add(placemark);
        map.behaviors.disable('scrollZoom');
      });
    }
  });
}

function resetProductFilter() {
    document.addEventListener('click', function(event) {
        if (event.target.id === 'resetForm') {
            let url = document.location.origin + document.location.pathname
            document.location = url
        }
    });
}
setValueForSearchInput();
function setValueForSearchInput() {
  let searchInptutStatic = document.querySelector('.js-search__input-static');
  let searchInptutMove = document.querySelector('.js-search__input-move');

  searchInptutStatic.addEventListener('keyup', function(event) {
    searchInptutMove.value = event.target.value;
  })
  searchInptutMove.addEventListener('keyup', function(event) {
    searchInptutStatic.value = event.target.value;
  })
}

function reloadPage() {
    location.reload();
}


