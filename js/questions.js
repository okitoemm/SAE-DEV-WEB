document.addEventListener('DOMContentLoaded', () => {
    const cureRadioYes = document.getElementById('oui');
    const cureRadioNo = document.getElementById('non');
    const cureDetails = document.getElementById('cure-details');

    cureRadioYes.addEventListener('change', () => {
        cureDetails.style.display = 'block';
    });

    cureRadioNo.addEventListener('change', () => {
        cureDetails.style.display = 'none';
    });
});