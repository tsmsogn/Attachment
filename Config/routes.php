<?php
Router::connect('/admin/attachment', array('plugin' => 'Attachment', 'admin' => true, 'controller' => 'attachments', 'action' => 'index'));
Router::connect('/admin/attachment/:controller', array('plugin' => 'Attachment', 'admin' => true, 'action' => 'index'));
Router::connect('/admin/attachment/:controller/:action/*', array('plugin' => 'Attachment', 'admin' => true));
