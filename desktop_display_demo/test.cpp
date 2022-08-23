#include <iostream>
#include <string.h>
#include <unistd.h>

#define WIDTH 8
#define HEIGHT 2 
#define NUMBER_OF_LINES 10

using namespace std;

uint8_t split_to_lines(char *message, char **tokens_array)
{
    uint8_t tokens = 1;
    tokens_array[0] = strtok(message, "\n");
    if (tokens_array[0] == NULL)
        return 1;
    for (uint8_t i = 1; i != NUMBER_OF_LINES; i++)
    {
        tokens_array[i] = strtok(NULL, "\n");
        if (tokens_array[i] != NULL)
            tokens++;
    }
    return tokens;
}

typedef struct Line
{
    char* ptr_line_text;
    int8_t position;
} Line;

void scroll_line (Line* ptr_line)
{
    // TODO: set cursor to specific line
    uint8_t length = strlen(ptr_line->ptr_line_text);
    for (int i = 0; i < WIDTH; i++)
    {
        if (ptr_line->position + i < 0)
            printf(" ");
        if (ptr_line->position + i >= 0 && ptr_line->position + i < length)
            printf("%c", *(ptr_line->ptr_line_text + ptr_line->position + i));
        if (ptr_line->position + i >= length)
            printf(" ");
    }

    if (ptr_line->position == length)
        ptr_line->position = -WIDTH;
    else
        ptr_line->position++;
}


int main(int argc, const char** argv)
{
    char message[] = "Pres";
    char *tokens[NUMBER_OF_LINES];
    split_to_lines(message, tokens);
    
    Line line1 = {};
    line1.ptr_line_text = tokens[0];
    line1.position = -WIDTH;
    
    for (int i = 0; i != 120; i++)
    {
        printf("\e[1;1H\e[2J");
        scroll_line(&line1);
        fflush(stdout);
        usleep(1000*200);
    }
    cout << "\n";
    return 0;
}