<!DOCTYPE html>
<head>
    <title>NBA</title>
    <meta charset="UTF-8">
    <meta name="author" content="Dawid Tarnawa">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="tlo1">
    <header>
        <img src="images/baner.png" alt="Opis zdjęcia"> 
    </header>
    
    <nav>
        <ul>
            <li><a href="index.html">Historia NBA</a></li>
            <li><a href="index2.html">Drużyny</a></li>
            <li><a href="index4.html">Bilety</a></li>
            <li><a href="index5.html">Kontakt</a></li>
        </ul>
    </nav>
    <section class="border-t py-4 mt-10 scroll-margin" id="book">
        <div class="w-[90%] max-w-screen-md mx-auto flex flex-col gap-8 ">
            <h2 class="text-4xl font-semibold mt-10 ">Księga gości</h2>

            <div class="flex flex-col gap-4">
                <div class="p-5 rounded-lg bg-white border flex flex-col gap-4 w-full lg:w-auto min-w-[250px]">
                    <h3 class="text-xl font-medium">Dodaj swój wpis</h3>
                    <form action="index.php" class="flex flex-col gap-4" method="POST">
                        <div class="flex flex-col gap-2">
                            <label for="title" class="text-sm font-medium text-gray-900">Tytuł</label>
                            <input type="text" placeholder="Tytuł..." name="title" id="title" minlength="5" maxlength="50" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"/>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="author" class="text-sm font-medium text-gray-900">Twoja nazwa</label>
                            <input type="text" placeholder="Jan Kowalski" name="author" id="author" required  minlength="5" maxlength="50" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"/>
                        </div>
                        <div>
                            <input type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center cursor-pointer" value="Dodaj wpis" />
                        </div>

                        <?php
                            include 'DB.php';

                            if($_SERVER["REQUEST_METHOD"] == "POST") {
                                if(empty($_REQUEST['title']) || empty($_REQUEST['author'])) {
                                    echo 'Pola nie mogą być puste!';
                                    return;
                                }

                                $title = $_REQUEST["title"];
                                $author = $_REQUEST["author"];

                                try {
                                    $sql = "INSERT INTO posts (title, author) VALUES (?, ?)";
                                    $stmt= $conn->prepare($sql);
                                    $stmt->execute([$title, $author]);
                                    $_POST = array();
                                    $message = "Dodano nowy wpis!";
                                    echo "<h2 class='text-medium'>Dodano nowy wpis!</h2>";
                                } catch(PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }

                            }
                        ?>
                    </form>
                </div>

                <div class="w-full flex flex-col gap-4">
                    <h3 class="text-2xl font-semibold">Ostatnie wpisy:</h3>
                    <ul class="grid gap-4 grid-cols-2 md:grid-cols-3">
                       
                    <?php
                        include 'db.php';

                        try {
                            $sql = "SELECT * FROM posts LIMIT 15";
                            $stmt = $conn->query($sql);

                            if ($stmt->rowCount() > 0) {
                                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<li class='p-4 rounded-lg bg-white border'>";
                                    echo "<h3 class='text-xl font-medium truncate'>" . htmlspecialchars($row["title"]) . "</h3>";
                                    echo "<p class='text-sm text-gray-500'>Autor: " . htmlspecialchars($row["author"]) . "</p>";
                                    echo "</li>";
                                }
                            } else {
                                echo "Nie znaleziono żadnych wpisów w księdze gości :(";
                            }
                        } catch(PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                    ?>
                
                    </ul>
                </div>

            </div>

        </div>
        
    </section>
</body>