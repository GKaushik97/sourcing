<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Exporter library
 * 
 */
class Exporter
{
    // For CodeIgniter super object
    private $CI;

    public function __construct()
    {
        // Assign CodeIgniter super object
        $this->CI =& get_instance();
    }

    /**
     * Export to CSV
     */
    public function toCSV($params)
    {
        // Set file name
        $file_name = isset($params['file_name']) ? $params['file_name'] : 'untitled';
        //-- Set headers
        header("Content-Description: File Transfer"); 
        header('Content-Disposition: attachment; filename=' . $file_name . '.csv');
        header('Content-Type: text/csv; charset=ISO-8859-1');
        
        // Open an output stream
        $file = fopen('php://output', 'w');
        
        // Add headers
        fputcsv($file, $params['headers']);
        
        // Add data
        foreach($params['content'] as $line) {
            fputcsv($file, $line);
        }
        
        // Close output stream
        fclose($file);
    }
}