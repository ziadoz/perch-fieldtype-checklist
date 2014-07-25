<?php
/**
 * Checklist Field Type.
 *
 * File:  PERCH_PATH/addons/fieldtypes/checklist/checklist.class.php
 * Usage: <perch:content id="features" type="checklist" label="Features" options="Feature 1, Feature 2, Feature 3" />
 * @author Jamie York
 **/
class PerchFieldType_checklist extends PerchAPI_FieldType
{
    /**
     * Output the form fields for the edit page.
     *
     * @param array $details
     * @return void
     */
    public function render_inputs($details = array())
    {
        $options = explode(',', $this->Tag->options());

        $id     = $this->Tag->input_id();
        $class  = $this->Tag->class();

        $opts = array();
        if (PerchUtil::count($options) > 0) {
            foreach($options as $option) {
                $value = trim($option);
                $label = $value;

                if (strpos($value, '|') !== false) {
                    $parts = explode('|', $value);
                    $label = $parts[0];
                    $value = $parts[1];
                }

                $opts[] = array('label' => $label, 'value' => $value);
            }
        }

        $checklist = '<fieldset class="checkboxes">';
        foreach ($opts as $opt) {
            $field   = $id . '_' . preg_replace('/[^a-z0-9_-]/i', '', $opt['value']);
            $checked = $this->checked($details, $id, $opt['value'], $this->Tag->post_prefix());

            $checklist .= '<div class="checkbox">';
            $checklist .= $this->Form->checkbox($field, $opt['value'], $checked, $class, $id);
            $checklist .= $this->Form->label($field, $opt['label'], '', $colon = false, $translate = false);
            $checklist .= '</div>';
        }
        $checklist .= '</fieldset>';

        return $checklist;
    }

    /**
     * Read in the form input, prepare data for storage in the database.
     *
     * @param string $post
     * @param object $item
     * @return void
     */
    public function get_raw($post = false, $item = false)
    {
        $id = $this->Tag->id();
        if (isset($post[$id]) && is_array($post[$id])) {
            return $post[$id];
        }

        return array();
    }

    /**
     * Take the raw data input and return process values for templating
     *
     * @param string $raw
     * @return void
     */
    public function get_processed($raw = false)
    {
        if ($raw === false) {
            $raw = $this->get_raw();
        }

        return implode(', ', (array) $raw);
    }

    /**
     * Get the value to be used for searching
     *
     * @param string $raw
     * @return void
     */
    public function get_search_text($raw = false)
    {
        if ($raw === false) {
            $raw = $this->get_raw();
        }

        return implode(', ', (array) $raw);
    }

    /**
     * Determine if a checkbox is checked.
     *
     * @param array $details
     * @param string $key
     * @param string $value
     * @return boolean
     **/
    public function checked($details, $key, $value)
    {
        $details = ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST) ? $_POST : $details);
        return (bool) isset($details[$key]) && in_array($value, $details[$key]);
    }
}