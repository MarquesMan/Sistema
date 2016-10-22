#include "janelacadastro.h"
#include <QApplication>

int main(int argc, char *argv[])
{
    QApplication a(argc, argv);
    JanelaCadastro w;
    w.show();

    return a.exec();
}
