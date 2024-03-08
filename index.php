<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Word Frequency Counter</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Word Frequency Counter</h1>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get user input
        $text = $_POST["text"];
        $sortOrder = $_POST["sort"];
        $limit = isset($_POST["limit"]) ? intval($_POST["limit"]) : 10;

        // Tokenize the text into words
        $words = str_word_count($text, 1);

        // Filter out common stop words (add more if needed)
        $stopWords = array("the", "and", "in", "to", "of", "a");
        $filteredWords = array_diff($words, $stopWords);

        // Calculate word frequencies
        $wordFrequencies = array_count_values($filteredWords);

        // Sort the word frequencies based on user choice
        if ($sortOrder == "asc") {
            asort($wordFrequencies);
        } else {
            arsort($wordFrequencies);
        }

        // Display the result
        echo "<h2>Word Frequency Result:</h2>"; 
        echo "<ul>";
        $counter = 0;
        foreach ($wordFrequencies as $word => $frequency) {
            echo "<li>{$word}: {$frequency}</li>";
            $counter++;
            if ($counter >= $limit) {
                break;
            }
        }
        echo "</ul>";
    } else {
        // Display the form if no form submission
    ?>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="text">Paste your text here:</label><br>
        <textarea id="text" name="text" rows="10" cols="50" required></textarea><br><br>
        
        <label for="sort">Sort by frequency:</label>
        <select id="sort" name="sort">
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>
        </select><br><br>
        
        <label for="limit">Number of words to display:</label>
        <input type="number" id="limit" name="limit" value="10" min="1"><br><br>
        
        <input type="submit" value="Calculate Word Frequency">
    </form>
    
    <?php
    }
    ?>
</body>
</html>
