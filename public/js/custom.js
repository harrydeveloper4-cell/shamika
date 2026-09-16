$(document).ready(function () {
  $('#faqAccordion').on('show.bs.collapse', function (e) {
    $(e.target).prev('.faq-header').find('.faq-icon i').removeClass('fa-plus').addClass('fa-minus');
  });

  $('#faqAccordion').on('hide.bs.collapse', function (e) {
    $(e.target).prev('.faq-header').find('.faq-icon i').removeClass('fa-minus').addClass('fa-plus');
  });
});