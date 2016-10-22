#ifndef JANELACADASTRO_H
#define JANELACADASTRO_H

#include <QWidget>

namespace Ui {
class JanelaCadastro;
}

class JanelaCadastro : public QWidget
{
    Q_OBJECT

public:
    explicit JanelaCadastro(QWidget *parent = 0);
    ~JanelaCadastro();

private:
    Ui::JanelaCadastro *ui;
};

#endif // JANELACADASTRO_H
