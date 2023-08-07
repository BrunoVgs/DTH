const validateBtn = document.getElementById('validateBtn');
const checkboxes = document.querySelectorAll('.appointment-checkbox');

checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', () => {
        const checkedCheckboxes = document.querySelectorAll('.appointment-checkbox:checked');
        validateBtn.style.display = checkedCheckboxes.length > 0 ? 'block' : 'none';
    });
});

validateBtn.addEventListener('click', () => {
    const checkedCheckboxes = document.querySelectorAll('.appointment-checkbox:checked');
    const appointmentIds = Array.from(checkedCheckboxes).map(checkbox => checkbox.dataset.id);
});

const selectAllBtn = document.getElementById('selectAllBtn');
const deselectAllBtn = document.getElementById('deselectAllBtn');

selectAllBtn.addEventListener('click', () => {
    checkboxes.forEach(checkbox => {
        checkbox.checked = true;
    });
    validateBtn.style.display = 'block';
});

deselectAllBtn.addEventListener('click', () => {
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
    validateBtn.style.display = 'none';
});
