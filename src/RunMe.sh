#!/bin/bash

# Determine the directory where the script is located
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="$SCRIPT_DIR/.."
JAVA_SRC="$PROJECT_ROOT/src/myJava/MySQLConnectionTest.java"
PHP_SCRIPT="$PROJECT_ROOT/src/php/MyFilePHP.php"
OUT_DIR="$PROJECT_ROOT/out"
HTML_OUTPUT="$PROJECT_ROOT/output.html"
LIB_DIR="$PROJECT_ROOT/lib"

# Paths to libraries (relative to the lib directory)
GSON_LIB="$LIB_DIR/gson-2.11.0.jar"
MYSQL_CONNECTOR_LIB="$LIB_DIR/mysql-connector-j-9.1.0.jar"

# Verify that libraries exist
for LIB in "$GSON_LIB" "$MYSQL_CONNECTOR_LIB"; do
    if [ ! -f "$LIB" ]; then
        echo "Error: Library not found: $LIB"
        exit 1
    fi
done

# Combine library paths for classpath
CLASSPATH="$GSON_LIB:$MYSQL_CONNECTOR_LIB"

# Compile and Run Java Program
echo "Running Java Program..."
sleep 2

if [ -f "$JAVA_SRC" ]; then
    # Compile Java
    javac -cp "$CLASSPATH" -d "$OUT_DIR" "$JAVA_SRC"
    if [ $? -eq 0 ]; then
        # Extract the class name and run it
        CLASS_NAME="myJava.MySQLConnectionTest"
        java -cp "$OUT_DIR:$CLASSPATH" "$CLASS_NAME"
        echo "Java program executed. Waiting..."
        sleep 4
    else
        echo "Java compilation failed!"
    fi
else
    echo "Java file not found at $JAVA_SRC"
fi

# Run PHP Script and Save Output to HTML
echo "- Running PHP Script and generating output.html..."
sleep 4
if [ -f "$PHP_SCRIPT" ]; then
    php "$PHP_SCRIPT" > "$HTML_OUTPUT"
    if [ $? -eq 0 ]; then
        echo "- PHP output saved to $HTML_OUTPUT"
        sleep 3
        # Open the HTML file in the default browser (macOS)
        if [[ "$OSTYPE" == "darwin"* ]]; then
            open "$HTML_OUTPUT"
        else
            echo "Please open $HTML_OUTPUT in your browser."
        fi
    else
        echo "PHP execution failed!"
    fi
else
    echo "PHP file not found at $PHP_SCRIPT"
fi

echo "Script execution completed."
