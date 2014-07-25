Perch Checklist Field Type
===========================

A Perch CMS field type for creating checklists.

# Requirements

* PHP 5.3+
* Perch CMS v2.4.9+

# Installation

Copy `perch/addons/fieldtypes/checklist` into your project `$PERCH/addons/fieldtypes` directory.

# Usage

To use the fieldtype, add into your template as follows:

```html
<perch:content id="features" type="checklist" label="Features" options="Feature 1, Feature 2, Feature 3" />
```