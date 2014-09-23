<?php

/**
 * @package		Joomla.Site
 * @subpackage	Contact
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

class ContactControllerContact extends JControllerForm {

    public function getModel($name = '', $prefix = '', $config = array('ignore_request' => true)) {
        return parent::getModel($name, $prefix, array('ignore_request' => false));
    }

    public function submit() {
        // Check for request forgeries.
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        // Initialise variables.
        $app = JFactory::getApplication();
        $model = $this->getModel('contact');
        $params = JComponentHelper::getParams('com_contact');
        $stub = JRequest::getString('id');
        $id = (int) $stub;

        // Get the data from POST
        $data = JRequest::getVar('jform', array(), 'post', 'array');

        $contact = $model->getItem($id);


        $params->merge($contact->params);

        // Check for a valid session cookie
        if ($params->get('validate_session', 0)) {
            if (JFactory::getSession()->getState() != 'active') {
                JError::raiseWarning(403, JText::_('COM_CONTACT_SESSION_INVALID'));

                // Save the data in the session.
                $app->setUserState('com_contact.contact.data', $data);

                // Redirect back to the contact form.
                $this->setRedirect(JRoute::_('index.php?option=com_contact&view=contact&id=' . $stub, false));
                return false;
            }
        }

        // Contact plugins
        JPluginHelper::importPlugin('contact');
        $dispatcher = JDispatcher::getInstance();

        // Validate the posted data.
        $form = $model->getForm();
        if (!$form) {
            JError::raiseError(500, $model->getError());
            return false;
        }

        $validate = $model->validate($form, $data);

        if ($validate === false) {
            // Get the validation messages.
            $errors = $model->getErrors();
            // Push up to three validation messages out to the user.
            for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
                if ($errors[$i] instanceof Exception) {
                    $app->enqueueMessage($errors[$i]->getMessage(), 'warning');
                } else {
                    $app->enqueueMessage($errors[$i], 'warning');
                }
            }

            // Save the data in the session.
            $app->setUserState('com_contact.contact.data', $data);

            // Redirect back to the contact form.
            $this->setRedirect(JRoute::_('index.php?option=com_contact&view=contact&id=' . $stub, false));
            return false;
        }

        // Validation succeeded, continue with custom handlers
        $results = $dispatcher->trigger('onValidateContact', array(&$contact, &$data));

        foreach ($results as $result) {
            if ($result instanceof Exception) {
                return false;
            }
        }

        // Passed Validation: Process the contact plugins to integrate with other applications
        $results = $dispatcher->trigger('onSubmitContact', array(&$contact, &$data));

        // Send the email
        $sent = false;
        if (!$params->get('custom_reply')) {
            $sent = $this->_sendEmail($data, $contact);
        }

        // Set the success message if it was a success
        if (!($sent instanceof Exception)) {
            $msg = JText::_('COM_CONTACT_EMAIL_THANKS');
        } else {
            $msg = '';
        }

        // Flush the data from the session
        $app->setUserState('com_contact.contact.data', null);

        // Redirect if it is set in the parameters, otherwise redirect back to where we came from
        if ($contact->params->get('redirect')) {
            $this->setRedirect($contact->params->get('redirect'), $msg);
        } else {
            $this->setRedirect(JRoute::_('index.php?option=com_contact&view=contact&id=' . $stub, false), $msg);
        }

        return true;
    }

    public function submitreport() {
        // Check for request forgeries.
        JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        // Initialise variables.
        $app = JFactory::getApplication();
        $model = $this->getModel('contact');
        $params = JComponentHelper::getParams('com_contact');
        $id = JRequest::getInt('id');

        // Get the data from POST

        $data = JRequest::getVar('jform', array(), 'post', 'array');
        $file = JRequest::getVar('attachFile', null, 'files', 'array');

        $data['contact_name'] = $data['name'];
        $data['contact_email'] = $data['email'];
        $data['contact_subject'] = "Report Pollution";
        $data['contact_message'] = "Report Pollution :
                    <table>
                    <tr><td> Name:    </td> <td>         " . $data['name'] . "</td></tr>
                    <tr><td> City:     </td><td>          " . $data['city'] . "</td></tr>
                    <tr><td> Email:    </td><td>          " . $data['email'] . "</td></tr>
                    </table>
                    Describe your pollution concern        " . $data['content'];


        $contact = $model->getItem($id);

        $params->merge($contact->params);

        $contact->email_to[0] = "djordan@mobilebaykeeper.org";
        $contact->email_to[1] = "quanglong05@gmail.com";
       // $contact->email_to[2] = "mark.roberts@epiphanydev.com";
//        $contact->email_to[3] = "";
        // 
        // Contact plugins
        JPluginHelper::importPlugin('contact');
        $dispatcher = JDispatcher::getInstance();

        //Import filesystem libraries. Perhaps not necessary, but does not hurt
        jimport('joomla.filesystem.file');

        //Clean up filename to get rid of strange characters like spaces etc
        $filename = JFile::makeSafe($file['name']);

        //Set up the source and destination of the file
        $src = $file['tmp_name'];
        $dest = JPATH_BASE . DS . "images" . DS . $filename;
        
        JFile::upload($src, $dest);
        
        // Send the email
        $sent = false;

        if (!$params->get('custom_reply')) {
            $sent = $this->_sendEmailNoise($data, $contact, $dest);
        }
        
        // Set the success message if it was a success
        if (!($sent instanceof Exception)) {
            $msg = JText::_('Thank you for your email.');
        } else {
            $msg = '';
        }
        
        
        $this->setRedirect(JRoute::_('index.php?option=com_contact&view=reportpollution&t=1',true), $msg);
        
        // Redirect if it is set in the parameters, otherwise redirect back to where we came from
//        $this->setRedirect(JRoute::_('index.php?option=com_contact&view=reportpollution', false), $msg);



        return true;
    }

    private function _sendEmailNoise($data, $contact, $dest) {
        $app = JFactory::getApplication();
        $params = JComponentHelper::getParams('com_contact');

        $mailfrom = $app->getCfg('mailfrom');
        $fromname = $app->getCfg('fromname');
        $sitename = $app->getCfg('sitename');

        $name = $data['contact_name'];
        $email = $data['contact_email'];
        $subject = $data['contact_subject'];
        $body = $data['contact_message'];

//        $contact->email_to = explode(',',$contact->email_to);
        // Prepare email body
        $prefix = JText::sprintf('COM_CONTACT_ENQUIRY_TEXT', JURI::base());
        $body = $prefix . "  " . $name . "<" . $email . ">" . "<br/><br/>" . stripslashes($body);
        $mail = JFactory::getMailer();
//        $mail->CharSet = 'us-ascii';
        $mail->addRecipient($contact->email_to);
        $mail->setSender(array($email, $name));
        $mail->setSubject($sitename . ': ' . $subject);
        $mail->addAttachment($dest); // For attach a file to email 
        $mail->setBody($body);
        $mail->IsHTML(true);
        $sent = $mail->Send();
        
        if (array_key_exists('email_copy', $data)) {
            $copytext = JText::sprintf('COM_CONTACT_COPYTEXT_OF', $contact->name, $sitename);
            $copytext .= "\r\n\r\n" . $body;
            $copysubject = JText::sprintf('COM_CONTACT_COPYSUBJECT_OF', $subject);

            $mail = JFactory::getMailer();
            $mail->addRecipient($email);
            $mail->addReplyTo(array($email, $name));
            $mail->addAttachment($dest); // For attach a file to email 
            $mail->setSender(array($mailfrom, $fromname));
            $mail->setSubject($copysubject);
            $mail->setBody($copytext);
			$mail->IsHTML(true);
            $sent = $mail->Send();
        }
        
        return $sent;
    }

    private function _sendEmail($data, $contact) {
        $app = JFactory::getApplication();
        $params = JComponentHelper::getParams('com_contact');
        if ($contact->email_to == '' && $contact->user_id != 0) {
            $contact_user = JUser::getInstance($contact->user_id);
            $contact->email_to = $contact_user->get('email');
        }
        $mailfrom = $app->getCfg('mailfrom');
        $fromname = $app->getCfg('fromname');
        $sitename = $app->getCfg('sitename');
        $copytext = JText::sprintf('COM_CONTACT_COPYTEXT_OF', $contact->name, $sitename);

        $name = $data['contact_name'];
        $email = $data['contact_email'];
        $subject = $data['contact_subject'];
        $body = $data['contact_message'];

        // Prepare email body
        $prefix = JText::sprintf('COM_CONTACT_ENQUIRY_TEXT', JURI::base());
        $body = $prefix . "\n" . $name . ' <' . $email . '>' . "\r\n\r\n" . stripslashes($body);

        $mail = JFactory::getMailer();
        $mail->addRecipient($contact->email_to);
        $mail->addReplyTo(array($email, $name));
        $mail->setSender(array($mailfrom, $fromname));
        $mail->setSubject($sitename . ': ' . $subject);
        $mail->setBody($body);
        $sent = $mail->Send();

        //If we are supposed to copy the sender, do so.
        // check whether email copy function activated
        if (array_key_exists('contact_email_copy', $data)) {
            $copytext = JText::sprintf('COM_CONTACT_COPYTEXT_OF', $contact->name, $sitename);
            $copytext .= "\r\n\r\n" . $body;
            $copysubject = JText::sprintf('COM_CONTACT_COPYSUBJECT_OF', $subject);

            $mail = JFactory::getMailer();
            $mail->addRecipient($email);
            $mail->addReplyTo(array($email, $name));
            $mail->setSender(array($mailfrom, $fromname));
            $mail->setSubject($copysubject);
            $mail->setBody($copytext);
            $sent = $mail->Send();
        }

        return $sent;
    }

}
