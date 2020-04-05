/*
 * C语言实现单链表操作
 * date:2015-05-17
 */
#include<stdio.h>
#include<malloc.h>
#define LEN sizeof(Node)
//定义结构体类型，存放学生信息的链表结点 
typedef struct student
{
    long num;   //学号
    float score;//分数 
    struct student *next; //指针指向下一学生信息个结点 
}Node, *LinkList;  //为struct student 结构体定义两个别名：Node和*LinkList
 
//全局变量，本文模块中各函数均可调用  
int n; 

/*创建一个新链表，返回表头指针*/
//struct student *create(void)
//Node *create(void)
LinkList create(void) //和以上两种情况等效
{
    //头指针top，头结点head
    Node  *top;
    //Node *p, *tmp; 
    LinkList p, tmp; 
    n = 0; 
    //定义头结点
    p = (struct student *)malloc(LEN); 
    top = p;         //头指针指向头结点
    p->next = NULL;  //头结点指针域指向NULL，代表空链表

    tmp = (struct student *)malloc(LEN); 
    //用户输入学生链表信息
    scanf("%ld, %f", &tmp->num, &tmp->score); 
    while(tmp->num!=0)
    {
        ++n; 
        p->next = tmp; 
        p = tmp; 
        tmp=(LinkList)malloc(LEN); 
        scanf("%ld, %f", &tmp->num, &tmp->score); 
    }
    p->next = NULL; 
    return top; 
}
/*
 * 删除指定学号的结点
 * 返回头指针
*/
LinkList del(Node *head, long num)
{
    LinkList cur, p, tmp; 
    //获取头结点的指针, 指向第一个学生信息结点元素
    //空链表情况
    cur = head->next; 
    if(cur  == NULL)
    {
        printf("\nList null\n"); 
    }
    //查找指定学号的结点 p
    while(num!=cur->num && cur->next!=NULL)
    {
        p = cur; 
        cur = cur->next; 
    }
    //如果查找到指定学号结点
    if(num == cur->num) 
    {
        p->next = cur->next; 
        free(cur); 
        --n; 
        printf("delete:%ld\n", num); 
    }else
    {
        printf("%ld not been found!\n", num); 
    }
    return  head; 
}
/*
 * 向链表中新插入结点
 * @param [point] - head 链表头指针
 * @param [point] - newNode 新结点
 * 返回头指针
*/
LinkList insert(Node *nhead, Node *nNode)
{
    LinkList cur, p, newNode; 
    cur = nhead; 
    cur = cur->next; 
    newNode = nNode; 

    //查找到在什么位置插入新结点
    while(newNode->num > cur->num && cur->next!=NULL)
    {
        p = cur; 
        cur = cur->next; 
    }
    //插入到链表中间
    if(newNode->num<=cur->num)
    {
        p->next = newNode; 
        newNode->next = cur; 
    }else
    //插入到链表最后
    {
        cur->next = newNode; 
        newNode->next = NULL; 
    }
    ++n; 
    return nhead; 
}
//打印链表
void print(LinkList head)
{
    Node *p; 
    printf("\nNow, These %d records are:\n", n); 
    p = head; 
    if(head!=NULL)
    {
        p = p->next;  //过滤掉头结点，从第一个结点开始遍历
        if(p!=NULL)
        {
            do
            {
                printf("%ld, %5.1f\n", p->num, p->score); 
                p=p->next; 
            }while(p!=NULL); 
        }
    }
}

main(void)
{
    Node *head, *stu, *create(void); 
    LinkList del(Node *head, long del_num); 
    LinkList insert(Node *head, Node *nNode); 

    //创建链表
    head = create(); 
    print(head); 

    //删除链表
    printf("\n input the delete number:");   
    long del_num; 
    scanf("%ld",&del_num ); 
    head = del(head,del_num); 
    print(head); 

    //向链表中插入新结点
    stu = (LinkList)malloc(LEN);  //新申请空间, 返回内存地址
    printf("\n place input  new student num and score :\n");   
    scanf("%ld, %f", &stu->num, &stu->score); 
    if(stu->num!=0)
    {
        head = insert(head, stu); 
        print(head); 
    }
}
