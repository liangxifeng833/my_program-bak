/*
 * 冒泡排序, 简单选择排序算法  
 * 2015-09-05 
 */
#include<stdio.h>
#include<malloc.h>

#define MAXSIZE 10 
#define TRUE 1
#define FALSE 0
typedef int status; 


//交换数组r[i] 和 r[j]的值
void swap(int *r, int i, int j)
{
    int tmp = r[i]; 
    r[i] = r[j]; 
    r[j] = tmp; 
}

/*
* 简单交换
*/
void bubbleSort_one(int *r, int len)
{
    int i, j; 
    for(i=0; i<len; i++)
    {
        for(j=i+1; j<len; j++)
        {
            if(r[i]>r[j])
            {
                swap(r, i, j); 
            }
        }
    }
}

/*
* 冒泡排序
*/
void bubbleSort_two(int *r, int len)
{
    int i, j; 
    for(i=0; i<len; i++)
    {
        for(j=len-2; j>=i; j--)
        {
            if(r[j]>r[j+1])
            {
                swap(r, j, j+1); 
            }
        }
    }
}
/*
* 冒泡排序优化
*/
void bubbleSort_three(int *r, int len)
{
    int i, j; 
    //设置标志位
    status flag=TRUE;   
    for(i=0; i<len && flag; i++)
    {
        flag = FALSE; 
        for(j=len-2; j>=i; j--)
        {
            if(r[j]>r[j+1])
            {
                swap(r, j, j+1); 
                flag=TRUE; 
            }
        }
    }
}
/*
* 简单选择排序
*/
void select_sort(int *r, int len)
{
    int i, j, min; 
    for(i=0; i<len; i++)
    {
        //将当前下标定义为最小下标
        min = i; 
        for(j=i+1; j<len; j++)
        {
            if(r[min]>r[j])
            {
                min = j; 
            }
        }
        //如果min!=1代表找到最小值, 接下来的操作就是交换了
        if(min!=i)
        {
            swap(r, i, min); 
        }
    }
}

main(void)
{
    int list[] = {9, 1, 5, 8, 3, 7, 4, 6, 2}; 
    int len,  i; 
    //求数组长度
    len = sizeof(list)/sizeof(int); 
    //bubbleSort_one(list, len); 
    //bubbleSort_two(list, len); 
    //bubbleSort_three(list, len); 
    select_sort(list, len); 
    for(i=0; i<len; i++)
    {
        printf("%d\n", list[i]); 
    }
}
