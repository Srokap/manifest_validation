<?php
manifest_validation::boot();
elgg_register_event_handler('init', 'system', array('manifest_validation', 'init'));
