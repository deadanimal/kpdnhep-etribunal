<?php

return [
    
    /**
     * The session key used to store the original user id.
     */
    'session_key' => config('app.name').'_impersonated_by',

    /**
     * The URI to redirect after taking an impersonation.
     *
     * Only used in the built-in controller.
     * * Use 'back' to redirect to the previous page
     */
    'take_redirect_to' => '/home',

    /**
     * The URI to redirect after leaving an impersonation.
     *
     * Only used in the built-in controller.
     * Use 'back' to redirect to the previous page
     */
    'leave_redirect_to' => '/home',

];
