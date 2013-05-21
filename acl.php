<?php
/**
 * This class will be called by the post_controller_constructor hook and act as ACL
 * 
 * @author ChristianGaertner
 */
class ACL {
    
    /**
     * Array to hold the rules
     * Keys are the role_id and values arrays
     * In this second level arrays the key is the controller and value an array with key method and value boolean
     * @var Array 
     */
    private static $perms;
    /**
     * The field name, which holds the role_id
     * @var string 
     */
    private static $role_field;
    /**
     * Contstruct in order to set rules
     * @author ChristianGaertner
     */
    public function __construct() {
        $this->role_field = 'role_id';
        

        
        $this->perms[0]['home']['index']        = true;
        $this->perms[0]['home']['about']        = true;
        $this->perms[1]['user']['dashboard']    = true;
        $this->perms[1]['user']['edit']         = true;
        $this->perms[1]['user']['show']         = true;
        $this->perms[2]['admin']['dashboard']   = true;
        $this->perms[3]['admin']['settings']    = true;
    }
    /**
     * The main method, determines if the a user is allowed to view a site
     * @author ChristianGaertner
     * @return boolean
     */
    public function auth()
    {
        $CI =& get_instance();
        
        if (!isset($CI->session))
        { # Sessions are not loaded
            $CI->load->library('session');
        }
        
        if (!isset($CI->session))
        { # Router is not loaded
            $CI->load->library('router');
        }
        
        
        $class = $CI->router->fetch_class();
        $method = $CI->router->fetch_method();

        // Is rule defined?
        $is_ruled = false;

        foreach ($this->perms as $role)
        { # Loop through all rules

            if (isset($role[$class][$method]))
            { # For this role exists a rule for this route
                $is_ruled = true;
            }

        }

        if (!$is_ruled)
        { # No rule defined for this route
            // ignording the ACL
            return;
        }

        
        
        if ($CI->session->userdata($this->role_field))
        { # Role_ID successfully determined ==> User is logged in
            if ($this->perms[$CI->session->userdata($this->role_field)][$class][$method])
            { # The user is allowed to enter the site
                return true;
            }
            else
            { # The user does not have permissions
                $CI->error->show(403);
            }
        }
        else
        { # not logged in
            if ($this->perms[0][$class][$method])
            { # The user is allowed to enter the site
                return true;
            }
            else
            { # The user does not have permissions
                $CI->error->show(403);
            }
        }

        
        
    }
}
