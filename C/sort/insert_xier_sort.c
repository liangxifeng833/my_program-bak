/*
 * 直接插入+希尔排序算法  
 * 2015-09-10 
 */
#include<stdio.h>
#include<malloc.h>


/*
* 直接插入排序
*/
void insert_sort(int *r, int len)
{
    int i, j; 
    //下标从1开始，默认下标0（一个元素）已经排好序（升序）
    for(i=2; i<=len; i++) 
    {
        if(r[i-1] > r[i])
        {
            //将较小值放入到tmp临时哨兵变量中
            r[0] = r[i]; 
            //我比你小，你就做到后面位置去，空出你的位置, 并且空座位一直向前移动
            for(j=i-1; r[j]>r[0]; j--)
            {
                r[j+1] = r[j]; 
            }
            //最终确定空座位的合理位置，然后我坐上去, 也就是插入到正确位置
            r[j+1] = r[0]; 
        }
    }
}
/*
* 希尔排序
*/
void xier_sort(int *r, int len)
{
    int i, j; 
    int increment = len; 
    do //按着不同的增量，对呆排序序列进行分组
    {
        //增量序列, “增量”到底设置成多少？到目前为止，貌似没有什么特别好的办法，各位就先采用已经有的代码的模式吧
        increment = increment/3+1; 
        //一次分组，每个小组内采用插入排序
        for(i=increment+1; i<=len; i++)
        {
            if(r[i]<r[i-increment])
            {
                r[0] = r[i]; 
                for(j=i-increment; j>0 && r[j]>r[0]; j-=increment)
                {
                    r[j+increment] = r[j]; 
                }
                r[j+increment] = r[0]; 
            }
        }
    }while(increment>1); 
}

main(void)
{
    int list[] = {0, 9, 1, 5, 8, 3, 7, 4, 6, 2, 10, 100, 98}; 
    int len,  i; 
    //求数组长度
    len = sizeof(list)/sizeof(int); 
    len = len-1; //len-1 数组下标为0作为哨兵，不计入实际长度
    //insert_sort(list, len); 
    xier_sort(list, len); 
    for(i=1; i<len+1; i++)
    {
        printf("%d\n", list[i]); 
    }
}
