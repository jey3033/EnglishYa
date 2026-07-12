import './bootstrap';

import TomSelect from 'tom-select';
import 'tom-select/dist/css/tom-select.css';
import AutoNumeric from 'autonumeric';

window.TomSelect = TomSelect;

window.AutoNumeric = AutoNumeric

new AutoNumeric('.autonumeric', {
    digitGroupSeparator: '.',
    decimalCharacter: ',',
    decimalPlaces: 0
});