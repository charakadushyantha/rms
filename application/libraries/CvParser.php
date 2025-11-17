<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CvParser {
    
    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }

    /**
     * Parse CV file and extract structured data
     */
    public function parse($file_path) {
        $start_time = microtime(true);
        
        try {
            // Detect file type
            $file_type = $this->detect_file_type($file_path);
            
            // Extract text based on file type
            $text = $this->extract_text($file_path, $file_type);
            
            if (empty($text)) {
                return ['success' => false, 'error' => 'Could not extract text from file'];
            }

            // Parse extracted text
            $data = $this->parse_text($text);
            
            $processing_time = round((microtime(true) - $start_time) * 1000);

            return [
                'success' => true,
                'data' => $data,
                'processing_time_ms' => $processing_time,
                'file_type' => $file_type
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Detect file type
     */
    private function detect_file_type($file_path) {
        $extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
        
        $types = [
            'pdf' => 'pdf',
            'doc' => 'doc',
            'docx' => 'docx',
            'txt' => 'txt',
            'jpg' => 'image',
            'jpeg' => 'image',
            'png' => 'image'
        ];

        return $types[$extension] ?? 'unknown';
    }

    /**
     * Extract text from file
     */
    private function extract_text($file_path, $file_type) {
        switch ($file_type) {
            case 'txt':
                return file_get_contents($file_path);

            case 'pdf':
                return $this->extract_from_pdf($file_path);

            case 'docx':
                return $this->extract_from_docx($file_path);

            case 'image':
                return $this->extract_from_image($file_path);

            default:
                throw new Exception('Unsupported file type');
        }
    }

    /**
     * Extract text from PDF
     */
    private function extract_from_pdf($file_path) {
        // Simple PDF text extraction (requires pdftotext or similar)
        // For production, use a proper PDF library
        
        if (function_exists('shell_exec')) {
            $output = shell_exec("pdftotext '$file_path' -");
            if ($output) return $output;
        }

        // Fallback: basic extraction
        $content = file_get_contents($file_path);
        return $this->extract_text_from_pdf_content($content);
    }

    /**
     * Basic PDF text extraction
     */
    private function extract_text_from_pdf_content($content) {
        $text = '';
        
        // Extract text between stream markers
        if (preg_match_all('/stream\s*(.+?)\s*endstream/s', $content, $matches)) {
            foreach ($matches[1] as $match) {
                $text .= $match . ' ';
            }
        }

        return $text;
    }

    /**
     * Extract text from DOCX
     */
    private function extract_from_docx($file_path) {
        $text = '';
        
        $zip = new ZipArchive();
        if ($zip->open($file_path) === TRUE) {
            $xml = $zip->getFromName('word/document.xml');
            $zip->close();
            
            if ($xml) {
                $xml = simplexml_load_string($xml);
                $text = strip_tags($xml->asXML());
            }
        }

        return $text;
    }

    /**
     * Extract text from image (OCR)
     */
    private function extract_from_image($file_path) {
        // Requires Tesseract OCR
        if (function_exists('shell_exec')) {
            $output = shell_exec("tesseract '$file_path' stdout 2>/dev/null");
            if ($output) return $output;
        }

        return '';
    }

    /**
     * Parse extracted text into structured data
     */
    private function parse_text($text) {
        return [
            'personal_info' => $this->extract_personal_info($text),
            'education' => $this->extract_education($text),
            'experience' => $this->extract_experience($text),
            'skills' => $this->extract_skills($text),
            'languages' => $this->extract_languages($text),
            'certifications' => $this->extract_certifications($text),
            'cv_quality_score' => $this->calculate_quality_score($text)
        ];
    }

    /**
     * Extract personal information
     */
    private function extract_personal_info($text) {
        $info = [];

        // Extract email
        if (preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $text, $matches)) {
            $info['email'] = $matches[0];
        }

        // Extract phone
        if (preg_match('/(\+94|0)?[0-9]{9,10}/', $text, $matches)) {
            $info['phone'] = $matches[0];
        }

        // Extract name (usually first line or near top)
        $lines = explode("\n", $text);
        foreach ($lines as $line) {
            $line = trim($line);
            if (strlen($line) > 5 && strlen($line) < 50 && preg_match('/^[A-Z][a-z]+\s+[A-Z]/i', $line)) {
                $info['name'] = $line;
                break;
            }
        }

        // Extract LinkedIn
        if (preg_match('/linkedin\.com\/in\/[\w-]+/', $text, $matches)) {
            $info['linkedin'] = $matches[0];
        }

        return $info;
    }

    /**
     * Extract education
     */
    private function extract_education($text) {
        $education = [];
        
        $degrees = ['bachelor', 'master', 'phd', 'diploma', 'degree', 'bsc', 'msc', 'ba', 'ma'];
        $lines = explode("\n", $text);

        foreach ($lines as $i => $line) {
            foreach ($degrees as $degree) {
                if (stripos($line, $degree) !== false) {
                    $education[] = [
                        'degree' => trim($line),
                        'institution' => isset($lines[$i + 1]) ? trim($lines[$i + 1]) : '',
                        'year' => $this->extract_year($line . ' ' . ($lines[$i + 1] ?? ''))
                    ];
                    break;
                }
            }
        }

        return $education;
    }

    /**
     * Extract work experience
     */
    private function extract_experience($text) {
        $experience = [];
        
        // Look for job titles and companies
        $job_keywords = ['developer', 'engineer', 'manager', 'analyst', 'designer', 'consultant'];
        $lines = explode("\n", $text);

        foreach ($lines as $i => $line) {
            foreach ($job_keywords as $keyword) {
                if (stripos($line, $keyword) !== false) {
                    $experience[] = [
                        'title' => trim($line),
                        'company' => isset($lines[$i + 1]) ? trim($lines[$i + 1]) : '',
                        'duration' => $this->extract_duration($line . ' ' . ($lines[$i + 1] ?? ''))
                    ];
                    break;
                }
            }
        }

        return $experience;
    }

    /**
     * Extract skills
     */
    private function extract_skills($text) {
        $technical_skills = [
            'PHP', 'Python', 'JavaScript', 'Java', 'C++', 'C#', 'Ruby', 'Go',
            'MySQL', 'PostgreSQL', 'MongoDB', 'Redis',
            'React', 'Angular', 'Vue', 'Node.js', 'Laravel', 'Django',
            'AWS', 'Azure', 'Docker', 'Kubernetes',
            'Git', 'CI/CD', 'Agile', 'Scrum'
        ];

        $soft_skills = [
            'Leadership', 'Communication', 'Problem Solving', 'Teamwork',
            'Time Management', 'Critical Thinking', 'Creativity'
        ];

        $found_technical = [];
        $found_soft = [];

        foreach ($technical_skills as $skill) {
            if (stripos($text, $skill) !== false) {
                $found_technical[] = $skill;
            }
        }

        foreach ($soft_skills as $skill) {
            if (stripos($text, $skill) !== false) {
                $found_soft[] = $skill;
            }
        }

        return [
            'technical' => $found_technical,
            'soft' => $found_soft
        ];
    }

    /**
     * Extract languages
     */
    private function extract_languages($text) {
        $languages = ['English', 'Sinhala', 'Tamil', 'Hindi', 'French', 'German', 'Spanish'];
        $found = [];

        foreach ($languages as $lang) {
            if (stripos($text, $lang) !== false) {
                $found[] = $lang;
            }
        }

        return $found;
    }

    /**
     * Extract certifications
     */
    private function extract_certifications($text) {
        $certs = [];
        $cert_keywords = ['certified', 'certification', 'certificate'];

        $lines = explode("\n", $text);
        foreach ($lines as $line) {
            foreach ($cert_keywords as $keyword) {
                if (stripos($line, $keyword) !== false) {
                    $certs[] = trim($line);
                    break;
                }
            }
        }

        return $certs;
    }

    /**
     * Extract year from text
     */
    private function extract_year($text) {
        if (preg_match('/\b(19|20)\d{2}\b/', $text, $matches)) {
            return $matches[0];
        }
        return '';
    }

    /**
     * Extract duration from text
     */
    private function extract_duration($text) {
        if (preg_match('/\d{4}\s*-\s*\d{4}/', $text, $matches)) {
            return $matches[0];
        }
        if (preg_match('/\d{4}\s*-\s*present/i', $text, $matches)) {
            return $matches[0];
        }
        return '';
    }

    /**
     * Calculate CV quality score
     */
    private function calculate_quality_score($text) {
        $score = 0;

        // Length check
        $length = strlen($text);
        if ($length > 500) $score += 20;
        if ($length > 1000) $score += 10;

        // Has email
        if (preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $text)) {
            $score += 15;
        }

        // Has phone
        if (preg_match('/(\+94|0)?[0-9]{9,10}/', $text)) {
            $score += 10;
        }

        // Has education keywords
        if (preg_match('/(bachelor|master|degree|university)/i', $text)) {
            $score += 15;
        }

        // Has experience keywords
        if (preg_match('/(experience|worked|developer|engineer|manager)/i', $text)) {
            $score += 15;
        }

        // Has skills section
        if (preg_match('/(skills|technologies|expertise)/i', $text)) {
            $score += 15;
        }

        return min($score, 100);
    }
}
