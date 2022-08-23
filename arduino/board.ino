#include <LiquidCrystal_I2C.h>
#include <arduino-timer.h>
#include "structures.h"

#define WIDTH 20
#define HEIGHT 2

char message[] = "Olomouc hl.n. pres Kralicky, Vrbatky, Blatec\nOdjezd 06:66, zpozdeni 150 minut";
/*
Os 3702 - 06:66
Olomouc hl.n.
pres Kralicky, Vrbatky, Blatec (rotuje)
Zpozdeni 150 minut

Os 3702
Olomouc hl.n. pres Kralicky, Vrbatky, Blatec (rotuje)
Odjezd 06:66
Zpozdeni 150 minut
*/
char *tokens[HEIGHT];
LiquidCrystal_I2C lcd(0x3F,20,4);
Line line1;

uint8_t split_to_lines(char *message, char **tokens_array)
{
    uint8_t tokens = 1;
    tokens_array[0] = strtok(message, "\n");
    if (tokens_array[0] == NULL)
        return 1;
    for (uint8_t i = 1; i != HEIGHT; i++)
    {
        tokens_array[i] = strtok(NULL, "\n");
        if (tokens_array[i] != NULL)
            tokens++;
    }
    return tokens;
}

void scroll_line (Line *ptr_line, LiquidCrystal_I2C *lcd)
{
    lcd->setCursor(0, 1);
    uint8_t length = strlen(ptr_line->ptr_line_text);
    char data[WIDTH+1] = {};

    for (int i = 0; i < WIDTH; i++)
    {
        if (ptr_line->position + i < 0)
            data[i] = ' ';
        if (ptr_line->position + i >= 0 && ptr_line->position + i < length)
            data[i] = *(ptr_line->ptr_line_text + ptr_line->position + i);
            //lcd->print(*(ptr_line->ptr_line_text + ptr_line->position + i));
        if (ptr_line->position + i >= length)
            data[i] = ' ';
    }
    lcd->print(data);

    if (ptr_line->position == length)
        ptr_line->position = -WIDTH;
    else
        ptr_line->position++;
}

void setup()
{
    lcd.init();
    lcd.backlight();

    split_to_lines(message, tokens);
    line1.ptr_line_text = tokens[0];
    line1.position = -WIDTH;
}

void loop()
{
    lcd.print("Os 3702 - 06:66");
    scroll_line(&line1, &lcd);
    delay(300);
}

