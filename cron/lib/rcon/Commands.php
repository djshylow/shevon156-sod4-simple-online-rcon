<?php defined('ROOT_PATH') or die('No direct script access.');

/**
 * Remote console commands
 *
 * @author		EpicLegion
 * @package		rcon
 * @subpackage	lib
 */
class Rcon_Commands {

    /**
     * Rcon connection
     *
     * @var	Rcon
     */
    protected $console = NULL;

    /**
     * Constructor
     *
     * @param	Rcon	$console
     */
    public function __construct(Rcon $console)
    {
        $this->console = $console;
    }

    /**
     * Ban player
     *
     * @param	string|int	$data
     * @param	bool		$ban_by_name
     */
    public function ban($data, $ban_by_name = FALSE)
    {
        // Name?
        if($ban_by_name)
        {
            // Ban by name
            $this->console->command('banuser "'.htmlspecialchars($data, ENT_QUOTES, 'UTF-8').'"');
        }
        else
        {
            // Ban by ID
            $this->console->command('banclient '.(int) $data);
        }
    }

    /**
     * Set c/dvar
     *
     * @param	string	$name
     * @param	mixed	$value
     * @param	bool	$dvar
     */
    public function cvar($name, $value, $dvar = FALSE)
    {
        // Admin dvar or cvar
        if($dvar)
        {
            $this->console->command('setadmindvar '.$name.' '.(is_int($value) ? $value : '"'.$value.'"'));
        }
        else
        {
            $this->console->command($name.' '.(is_int($value) ? $value : '"'.$value.'"'));
        }
    }

    /**
     * Get basic server info (map and player list)
     *
     * @return	array
     */
    public function get_server_info()
    {
        // Send command
        $response = $this->console->command('teamstatus');

        // Break lines
        $response = explode("\n", $response);

        // Valid response?
        if(count($response) <= 1)
        {
            throw new Exception('Cannot retrieve server info');
        }

        // Array containing server info
        $server_info = array(
            'map' => substr($response[0], 5),
            'players' => array(

            ),
            'error' => ''
        );

        // Remove header
        unset($response[0], $response[1], $response[2]);

        // Reader object
        $parser = new Rcon_Statusparser;

        // Iterate players
        foreach($response as $line)
        {
            // Not a player?
            if(empty($line) OR strlen($line) < 80)
            {
                break;
            }

            // Parse line
            $line = $parser->parse($line);

            // Set player info
            $server_info['players'][$line['id']] = $line;
        }

        // Return
        return $server_info;
    }

    /**
     * Kick player
     *
     * @param	string|int	$data
     * @param	bool		$kick_by_name
     */
    public function kick($data, $kick_by_name = FALSE)
    {
        // Name?
        if($kick_by_name)
        {
            // Kick by name
            $this->console->command('kick "'.htmlspecialchars($data, ENT_QUOTES, 'UTF-8').'"');
        }
        else
        {
            // Kick by ID
            $this->console->command('clientkick '.(int) $data);
        }
    }

    /**
     * Message (public or private)
     *
     * @param	string		$message
     * @param	string|int	$client
     */
    public function message($message, $client = 'all')
    {
        // Global say
        if($client == 'all')
        {
            $this->console->command('say "'.strip_tags($message).'"');
        }
        else
        {
            // Client ID have to be int
            $client = (int) $client;

            // Send tell command
            $this->console->command('tell '.$client.' "'.strip_tags($message).'"');
        }
    }

    /**
     * Set rcon console
     *
     * @param	Rcon	$console
     */
    public function set_rcon(Rcon $console)
    {
        $this->console = $console;
    }

    /**
     * Temporary ban player
     *
     * @param	string|int	$data
     * @param	bool		$ban_by_name
     */
    public function temp_ban($data, $ban_by_name = FALSE)
    {
        // Name?
        if($ban_by_name)
        {
            // Ban by name
            $this->console->command('tempbanuser "'.htmlspecialchars($data, ENT_QUOTES, 'UTF-8').'"');
        }
        else
        {
            // Ban by ID
            $this->console->command('tempbanclient '.(int) $data);
        }
    }
}