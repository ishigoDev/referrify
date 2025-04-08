jQuery(document).ready(function($) {
    // Get Active Jobs link text
    const activeJobsLink = $('.woocommerce-MyAccount-navigation-link--active-jobs a');
    const postedJobsLink = $('.woocommerce-MyAccount-navigation-link--posted-jobs a');
    
    // For Active Jobs
    const activeText = activeJobsLink.text();
    const activeMatch = activeText.match(/\((\d+)\)/);
    if (activeMatch) {
        const activeNumber = activeMatch[1];
        activeJobsLink.html(`Active Jobs <span class="job-count">${activeNumber}</span>`);
    }

    // For Posted Jobs
    const postedText = postedJobsLink.text();
    const postedMatch = postedText.match(/\((\d+)\)/);
    if (postedMatch) {
        const postedNumber = postedMatch[1];
        postedJobsLink.html(`All Posted Jobs <span class="job-count">${postedNumber}</span>`);
    }
});